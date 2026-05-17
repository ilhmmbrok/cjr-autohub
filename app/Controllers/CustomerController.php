<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\BookingModel;
use App\Models\ScheduleModel;
use App\Models\UserModel;

class CustomerController extends Controller
{
    private BookingModel  $bookingModel;
    private ScheduleModel $scheduleModel;
    private UserModel $userModel;


    public function __construct()
    {
        $this->bookingModel  = new BookingModel();
        $this->scheduleModel = new ScheduleModel();
        $this->userModel = new UserModel();

    }

    public function customerDashboard(): void
    {
        $user     = Auth::user('customer');
        $schedule = $this->scheduleModel->getBusinessHours();
        $stats    = $this->bookingModel->countByStatus($user['id']);

        $this->view('customer.Dashboard', [
            'user'            => $user,
            'bookings'        => $this->bookingModel->getBookingByCustomerId($user['id']),
            'totalPending'    => $stats['Pending'],
            'totalInProgress' => $stats['In Progress'],
            'totalCompleted'  => $stats['Completed'],
            'schedule'        => $schedule ?: [],
            'slotInfo'        => $this->buildSlotInfo($schedule),
        ]);
    }

    /**
     * Hitung info slot besok (H-1) jika jadwal tersedia.
     * Karena booking minimal H-1, tampilkan ketersediaan besok.
     */
    private function buildSlotInfo(array|false $schedule): array
    {
        if (!$schedule) {
            return [];
        }

        $maxSlot = (int) $schedule['slot_capacity'];
        $date    = date('Y-m-d', strtotime('+1 day'));
        $booked  = $this->bookingModel->countBookingsByDate($date);

        return [[
            'date'      => $date,
            'booked'    => $booked,
            'available' => max(0, $maxSlot - $booked),
            'max'       => $maxSlot,
        ]];
    }

    public function profileView(): void
    {
        $user = Auth::user('customer');
        $fullUser = $this->userModel->findById($user['id']);

        $this->view('customer.Profile', [
            'user' => array_merge($user, [
                'phone' => $fullUser['phone'] ?? '',
            ]),
        ]);
    }

    public function updateProfile(): void
    {
        $user = Auth::user('customer');

        ['fullname' => $fullname, 'email' => $email, 'phone' => $phone]
            = $this->input(['fullname', 'email', 'phone']);

        if (empty($fullname) || empty($email)) {
            $this->abort('error', 'Nama dan email wajib diisi.', '/profile');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->abort('error', 'Format email tidak valid.', '/profile');
        }

        // Cek apakah email sudah dipakai user lain
        $existing = $this->userModel->findByEmail($email);
        if ($existing && (int) $existing['id'] !== (int) $user['id']) {
            $this->abort('error', 'Email sudah digunakan oleh akun lain.', '/profile');
        }

        // Validasi format nomor telepon (opsional)
        if (!empty($phone) && !preg_match('/^[0-9+\-\s()]{8,20}$/', $phone)) {
            $this->abort('error', 'Format nomor telepon tidak valid.', '/profile');
        }

        $this->userModel->updateProfile($user['id'], [
            'fullname' => $fullname,
            'email'    => $email,
            'phone'    => $phone ?: null,
        ]);

        // Refresh session data
        Auth::updateSession('customer', [
            'fullname' => $fullname,
            'email'    => $email,
            'phone'    => $phone ?: null,
        ]);

        $this->abort('success', 'Profil berhasil diperbarui.', '/profile');
    }

    public function updatePassword(): void
    {
        $user = Auth::user('customer');

        ['old_password' => $oldPassword, 'new_password' => $newPassword, 'confirm_password' => $confirmPassword]
            = $this->input(['old_password', 'new_password', 'confirm_password']);

        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            $this->abort('error', 'Semua field password wajib diisi.', '/profile');
        }

        if (strlen($newPassword) < 8) {
            $this->abort('error', 'Password baru minimal 8 karakter.', '/profile');
        }

        if ($newPassword !== $confirmPassword) {
            $this->abort('error', 'Konfirmasi password tidak cocok.', '/profile');
        }

        // Verifikasi password lama
        $fullUser = $this->userModel->findById($user['id']);
        if (!$fullUser || !password_verify($oldPassword, $fullUser['password'])) {
            $this->abort('error', 'Password lama tidak benar.', '/profile');
        }

        $this->userModel->updatePassword($user['id'], password_hash($newPassword, PASSWORD_DEFAULT));

        $this->abort('success', 'Password berhasil diubah.', '/profile');
    }
}
