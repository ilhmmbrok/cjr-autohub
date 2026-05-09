<?php

namespace App\Models;

use App\Core\Database;

class BookingModel
{
    protected $table = 'bookings';

    public function findBooking(int $id)
    {
        return Database::fetch(
            "SELECT b.*, u.fullname AS customer_name
             FROM {$this->table} b
             LEFT JOIN users u ON u.id = b.customer_id
             WHERE b.booking_id = ?",
            [$id]
        );
    }

    public function getAllBookings(): array
    {
        return Database::fetchAll(
            "SELECT b.*, u.fullname AS customer_name
             FROM {$this->table} b
             LEFT JOIN users u ON u.id = b.customer_id
             ORDER BY b.booking_date ASC, b.checkin_time ASC"
        );
    }

    public function getBookingByCustomerId(int $id): array
    {
        return Database::fetchAll(
            "SELECT * FROM {$this->table}
             WHERE customer_id = ?
             ORDER BY booking_date DESC, checkin_time DESC",
            [$id]
        );
    }

    public function createBooking(array $data): int
    {
        return Database::execute(
            "INSERT INTO {$this->table}
                (customer_id, phone, address, vehicle_type, model_year,
                 plate_number, customer_complaint, booking_date, checkin_time)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['customer_id'],
                $data['phone'],
                $data['address'],
                $data['vehicle_type'],
                $data['model_year'],
                strtoupper($data['plate_number']),
                $data['customer_complaint'],
                $data['booking_date'],
                $data['checkin_time'],
            ]
        );
    }

    public function updateBooking(int $id, array $data): int
    {
        return Database::execute(
            "UPDATE {$this->table}
             SET phone = ?, address = ?, vehicle_type = ?, model_year = ?,
                 plate_number = ?, customer_complaint = ?,
                 booking_date = ?, checkin_time = ?
             WHERE booking_id = ?",
            [
                $data['phone'],
                $data['address'],
                $data['vehicle_type'],
                $data['model_year'],
                strtoupper($data['plate_number']),
                $data['customer_complaint'],
                $data['booking_date'],
                $data['checkin_time'],
                $id,
            ]
        );
    }

    public function updateStatus(int $id, string $status): int
    {
        return Database::execute(
            "UPDATE {$this->table} SET progress_status = ? WHERE booking_id = ?",
            [$status, $id]
        );
    }

    public function deleteBooking(int $id): int
    {
        return Database::execute(
            "DELETE FROM {$this->table} WHERE booking_id = ?",
            [$id]
        );
    }

    public function countBookingsByDate(string $date): int
    {
        $result = Database::fetch(
            "SELECT COUNT(*) AS total FROM {$this->table}
             WHERE booking_date = ? AND progress_status != 'Cancelled'",
            [$date]
        );
        return (int)($result['total'] ?? 0);
    }

    public function getNextQueueNumber(string $date): int
    {
        return $this->countBookingsByDate($date) + 1;
    }

    public function deleteCancelledBookings(): int
    {
        return Database::execute(
            "DELETE FROM {$this->table} WHERE progress_status = 'Cancelled'"
        );
    }

    /**
     * Hitung jumlah booking berdasarkan status.
     * Jika $customerId diberikan, hitung hanya untuk customer tersebut.
     */
    public function countByStatus(?int $customerId = null): array
    {
        $where = $customerId ? " WHERE customer_id = ?" : "";
        $params = $customerId ? [$customerId] : [];

        $rows = Database::fetchAll(
            "SELECT progress_status, COUNT(*) AS total
             FROM {$this->table}
             {$where}
             GROUP BY progress_status",
            $params
        );

        $stats = [
            'Pending'        => 0,
            'Admin Approved' => 0,
            'In Progress'    => 0,
            'Completed'      => 0,
            'Cancelled'      => 0,
        ];

        foreach ($rows as $row) {
            $stats[$row['progress_status']] = (int) $row['total'];
        }

        return $stats;
    }

    /**
     * Data booking per bulan untuk tahun tertentu (chart admin dashboard).
     */
    public function getMonthlyStats(int $year): array
    {
        $rows = Database::fetchAll(
            "SELECT MONTH(booking_date) AS bulan, COUNT(*) AS total
             FROM {$this->table}
             WHERE YEAR(booking_date) = ?
             GROUP BY MONTH(booking_date)",
            [$year]
        );

        $data = array_fill(0, 12, 0);
        foreach ($rows as $row) {
            $data[(int) $row['bulan'] - 1] = (int) $row['total'];
        }

        return $data;
    }
}
