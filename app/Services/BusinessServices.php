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

    public function createBooking(array $data): array
    {
        // 1. Validasi field wajib
        $required = [
            'customer_id', 'phone', 'address', 'vehicle_type',
            'model_year', 'plate_number', 'customer_complaint',
            'booking_date', 'checkin_time',
        ];
        foreach ($required as $field) {
            if (empty(trim((string)($data[$field] ?? '')))) {
                return ['success' => false, 'message' => 'Semua field wajib diisi.'];
            }
        }

        // 2. Ambil waktu lokal sekarang (WIB)
        $nowDT   = new DateTime('now', $this->timezone);
        $today   = $nowDT->format('Y-m-d');
        $nowTime = $nowDT->format('H:i:s');

        // 3. Validasi format tanggal
        $parsedDate = DateTime::createFromFormat('Y-m-d', $data['booking_date']);
        if (!$parsedDate || $parsedDate->format('Y-m-d') !== $data['booking_date']) {
            return ['success' => false, 'message' => 'Format tanggal tidak valid.'];
        }
        if ($data['booking_date'] < $today) {
            return ['success' => false, 'message' => 'Tanggal tidak boleh di masa lalu.'];
        }

        // 4. Validasi format waktu
        $parsedTime = DateTime::createFromFormat('H:i', $data['checkin_time']);
        if (!$parsedTime || $parsedTime->format('H:i') !== $data['checkin_time']) {
            return ['success' => false, 'message' => 'Format waktu tidak valid.'];
        }

        // 5. Ambil jadwal — dipakai untuk semua cek berikutnya
        $schedule = $this->scheduleModel->getBusinessHours();
        if (!$schedule) {
            return ['success' => false, 'message' => 'Jam operasional belum diatur oleh admin.'];
        }

        $openTime  = $schedule['open_time'];
        $closeTime = $schedule['close_time'];
        $maxSlot   = (int) $schedule['slot_capacity'];

        $openFormatted  = date('H:i', strtotime($openTime));
        $closeFormatted = date('H:i', strtotime($closeTime));

        // 6. Cek apakah sekarang dalam jam operasional (pakai waktu lokal WIB)
        if ($nowTime < $openTime || $nowTime > $closeTime) {
            return [
                'success' => false,
                'message' => "Jam operasional adalah $openFormatted sampai $closeFormatted.",
            ];
        }

        // 7. Cek jam check-in dalam range operasional
        $checkin = $data['checkin_time'] . ':00';
        if ($checkin < $openTime || $checkin > $closeTime) {
            return [
                'success' => false,
                'message' => "Jam check-in harus antara $openFormatted sampai $closeFormatted.",
            ];
        }

        // 7b. Jika booking hari ini, jam check-in tidak boleh di masa lalu
        if ($data['booking_date'] === $today && $checkin < $nowTime) {
            return [
                'success' => false,
                'message' => 'Jam check-in tidak boleh di masa lalu.',
            ];
        }

        // 8. Cek slot + insert dalam satu transaksi (cegah race condition)
        try {
            $db = Database::connect();
            $db->beginTransaction();

            $row   = Database::fetch(
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
}