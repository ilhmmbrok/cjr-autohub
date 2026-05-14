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

    public function __construct()
    {
        $this->bookingModel  = new BookingModel();
        $this->scheduleModel = new ScheduleModel();
        $this->timezone      = new DateTimeZone('Asia/Jakarta');
    }

    private function getToday(): string
    {
        return (new DateTime('now', $this->timezone))->format('Y-m-d');
    }

    private function validateBookingDateTime(string $date, string $checkinTime, array $schedule): ?array
    {
        // Trim detik jika ada — "10:00:00" → "10:00"
        $checkinTime = substr($checkinTime, 0, 5);

        $today = $this->getToday();

        // Tanggal harus minimal besok
        $parsedDate = DateTime::createFromFormat('Y-m-d', $date);
        if (!$parsedDate || $parsedDate->format('Y-m-d') !== $date) {
            return ['success' => false, 'message' => 'Format tanggal tidak valid.'];
        }
        if ($date <= $today) {
            return ['success' => false, 'message' => 'Tanggal booking minimal besok.'];
        }

        // Validasi format jam
        $parsedTime = DateTime::createFromFormat('H:i', $checkinTime);
        if (!$parsedTime || $parsedTime->format('H:i') !== $checkinTime) {
            return ['success' => false, 'message' => 'Format waktu tidak valid.'];
        }

        // Jam check-in harus dalam jam operasional
        $openTime  = $schedule['open_time'];
        $closeTime = $schedule['close_time'];
        $checkin   = $checkinTime . ':00';
        $fmt       = fn($t) => date('H:i', strtotime($t));

        if ($checkin < $openTime || $checkin > $closeTime) {
            return [
                'success' => false,
                'message' => "Jam check-in harus antara {$fmt($openTime)} sampai {$fmt($closeTime)}.",
            ];
        }

        return null;
    }

    public function createBooking(array $data): array
    {
        // 1. Validasi field wajib
        $required = [
            'customer_id',
            'phone',
            'address',
            'vehicle_type',
            'model_year',
            'plate_number',
            'customer_complaint',
            'booking_date',
            'checkin_time',
        ];
        foreach ($required as $field) {
            if (empty(trim((string)($data[$field] ?? '')))) {
                return ['success' => false, 'message' => 'Semua field wajib diisi.'];
            }
        }

        // 2. Ambil jadwal operasional
        $schedule = $this->scheduleModel->getBusinessHours();
        if (!$schedule) {
            return ['success' => false, 'message' => 'Jam operasional belum diatur oleh admin.'];
        }

        // 3. Validasi tanggal & jam
        $error = $this->validateBookingDateTime($data['booking_date'], $data['checkin_time'], $schedule);
        if ($error) return $error;

        // 4. Cek slot + insert dalam satu transaksi
        try {
            $db = Database::connect();
            $db->beginTransaction();

            $maxSlot = (int) $schedule['slot_capacity'];
            $row     = Database::fetch(
                "SELECT COUNT(*) AS total FROM bookings
                 WHERE booking_date = ? AND progress_status != 'Cancelled'
                 FOR UPDATE",
                [$data['booking_date']]
            );
            $total = (int)($row['total'] ?? 0);

            if ($total >= $maxSlot) {
                $db->rollBack();
                return ['success' => false, 'message' => 'Slot booking sudah penuh. Silahkan pilih tanggal lain.'];
            }

            $this->bookingModel->createBooking($data);

            $db->commit();
            return ['success' => true, 'message' => 'Booking berhasil.'];
        } catch (Exception $e) {
            $db->rollBack();
            error_log('BusinessServices::createBooking — ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan. Silahkan coba lagi.'];
        }
    }

    public function updateBooking(int $id, array $data): array
    {
        // 1. Validasi field wajib
        $required = [
            'phone',
            'address',
            'vehicle_type',
            'model_year',
            'plate_number',
            'customer_complaint',
            'booking_date',
            'checkin_time',
        ];
        foreach ($required as $field) {
            if (empty(trim((string)($data[$field] ?? '')))) {
                return ['success' => false, 'message' => 'Semua field wajib diisi.'];
            }
        }

        // 2. Ambil booking lama
        $booking = $this->bookingModel->findBooking($id);
        if (!$booking) {
            return ['success' => false, 'message' => 'Booking tidak ditemukan.'];
        }

        // 3. Cek booking lama — harus minimal H-1 (booking_date > hari ini)
        $today = $this->getToday();
        if ($booking['booking_date'] <= $today) {
            return ['success' => false, 'message' => 'Booking tidak bisa diubah kurang dari H-1.'];
        }

        // 4. Ambil jadwal operasional
        $schedule = $this->scheduleModel->getBusinessHours();
        if (!$schedule) {
            return ['success' => false, 'message' => 'Jam operasional belum diatur oleh admin.'];
        }

        // 5. Validasi tanggal baru & jam
        $error = $this->validateBookingDateTime($data['booking_date'], $data['checkin_time'], $schedule);
        if ($error) return $error;

        // 6. Cek slot + update dalam satu transaksi
        //    Hanya cek slot jika tanggal berubah
        try {
            $db = Database::connect();
            $db->beginTransaction();

            $dateChanged = $data['booking_date'] !== $booking['booking_date'];

            if ($dateChanged) {
                $maxSlot = (int) $schedule['slot_capacity'];
                $row     = Database::fetch(
                    "SELECT COUNT(*) AS total FROM bookings
                     WHERE booking_date = ? AND progress_status != 'Cancelled'
                     FOR UPDATE",
                    [$data['booking_date']]
                );
                $total = (int)($row['total'] ?? 0);

                if ($total >= $maxSlot) {
                    $db->rollBack();
                    return ['success' => false, 'message' => 'Slot booking sudah penuh. Silahkan pilih tanggal lain.'];
                }
            }

            $this->bookingModel->updateBooking($id, $data);

            $db->commit();
            return ['success' => true, 'message' => 'Booking berhasil diubah.'];
        } catch (Exception $e) {
            $db->rollBack();
            error_log('BusinessServices::updateBooking — ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan saat mengubah booking. Silahkan coba lagi.'];
        }
    }
}
