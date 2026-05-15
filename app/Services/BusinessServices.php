<?php

namespace App\Services;

use App\Core\Database;
use App\Models\BookingModel;
use App\Models\ScheduleModel;
use DateTime;
use DateTimeZone;
use Exception;

class BusinessServices
{
    private BookingModel  $bookingModel;
    private ScheduleModel $scheduleModel;
    private DateTimeZone  $timezone;

    private const REQUIRED_FIELDS = [
        'phone', 'address', 'vehicle_type', 'model_year',
        'plate_number', 'customer_complaint', 'booking_date', 'checkin_time',
    ];

    public function __construct()
    {
        $this->bookingModel  = new BookingModel();
        $this->scheduleModel = new ScheduleModel();
        $this->timezone      = new DateTimeZone('Asia/Jakarta');
    }

    // -------------------------------------------------------------------------
    // Public API
    // -------------------------------------------------------------------------

    public function createBooking(array $data): array
    {
        if ($error = $this->validateFields($data, ['customer_id', ...self::REQUIRED_FIELDS])) {
            return $error;
        }

        if (!$schedule = $this->scheduleModel->getBusinessHours()) {
            return $this->fail('Jam operasional belum diatur oleh admin.');
        }

        if ($error = $this->validateBookingDateTime($data['booking_date'], $data['checkin_time'], $schedule)) {
            return $error;
        }

        return $this->transact(function () use ($data, $schedule) {
            if ($error = $this->checkSlotAvailability($data['booking_date'], $schedule)) {
                return $error;
            }

            $this->bookingModel->createBooking($data);
            return $this->ok('Booking berhasil.');
        });
    }

    public function updateBooking(int $id, array $data): array
    {
        if ($error = $this->validateFields($data, self::REQUIRED_FIELDS)) {
            return $error;
        }

        if (!$booking = $this->bookingModel->findBooking($id)) {
            return $this->fail('Booking tidak ditemukan.');
        }

        if ($booking['booking_date'] <= $this->today()) {
            return $this->fail('Booking tidak bisa diubah kurang dari H-1.');
        }

        if (!$schedule = $this->scheduleModel->getBusinessHours()) {
            return $this->fail('Jam operasional belum diatur oleh admin.');
        }

        if ($error = $this->validateBookingDateTime($data['booking_date'], $data['checkin_time'], $schedule)) {
            return $error;
        }

        return $this->transact(function () use ($id, $data, $booking, $schedule) {
            // Cek slot hanya jika tanggal berubah
            if ($data['booking_date'] !== $booking['booking_date']) {
                if ($error = $this->checkSlotAvailability($data['booking_date'], $schedule)) {
                    return $error;
                }
            }

            $this->bookingModel->updateBooking($id, $data);
            return $this->ok('Booking berhasil diubah.');
        });
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function today(): string
    {
        return (new DateTime('now', $this->timezone))->format('Y-m-d');
    }

    /** @return array{success:false,message:string}|null */
    private function validateFields(array $data, array $fields): ?array
    {
        foreach ($fields as $field) {
            if (empty(trim((string) ($data[$field] ?? '')))) {
                return $this->fail('Semua field wajib diisi.');
            }
        }

        return null;
    }

    /** @return array{success:false,message:string}|null */
    private function validateBookingDateTime(string $date, string $checkinTime, array $schedule): ?array
    {
        $checkinTime = substr($checkinTime, 0, 5); // strip seconds jika ada

        $parsed = DateTime::createFromFormat('Y-m-d', $date);
        if (!$parsed || $parsed->format('Y-m-d') !== $date) {
            return $this->fail('Format tanggal tidak valid.');
        }

        if ($date <= $this->today()) {
            return $this->fail('Tanggal booking minimal besok.');
        }

        $parsedTime = DateTime::createFromFormat('H:i', $checkinTime);
        if (!$parsedTime || $parsedTime->format('H:i') !== $checkinTime) {
            return $this->fail('Format waktu tidak valid.');
        }

        $checkin   = $checkinTime . ':00';
        $open      = $schedule['open_time'];
        $close     = $schedule['close_time'];
        $fmt       = fn(string $t) => date('H:i', strtotime($t));

        if ($checkin < $open || $checkin > $close) {
            return $this->fail("Jam check-in harus antara {$fmt($open)} sampai {$fmt($close)}.");
        }

        return null;
    }

    /** @return array{success:false,message:string}|null */
    private function checkSlotAvailability(string $date, array $schedule): ?array
    {
        $maxSlot = (int) $schedule['slot_capacity'];
        $row     = Database::fetch(
            "SELECT COUNT(*) AS total FROM bookings
             WHERE booking_date = ? AND progress_status != 'Cancelled'
             FOR UPDATE",
            [$date]
        );

        if ((int) ($row['total'] ?? 0) >= $maxSlot) {
            return $this->fail('Slot booking sudah penuh. Silahkan pilih tanggal lain.');
        }

        return null;
    }

    /**
     * Jalankan callback di dalam transaksi DB.
     * Rollback otomatis jika terjadi Exception atau callback return error.
     */
    private function transact(callable $callback): array
    {
        $db = Database::connect();
        $db->beginTransaction();

        try {
            $result = $callback();

            if (!$result['success']) {
                $db->rollBack();
                return $result;
            }

            $db->commit();
            return $result;
        } catch (Exception $e) {
            $db->rollBack();
            error_log('BusinessServices::transact — ' . $e->getMessage());
            return $this->fail('Terjadi kesalahan. Silahkan coba lagi.');
        }
    }

    private function ok(string $message): array
    {
        return ['success' => true, 'message' => $message];
    }

    private function fail(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }
}
