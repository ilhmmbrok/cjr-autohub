<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\BookingModel;
use App\Models\ScheduleModel;
use App\Services\BusinessServices;

class BookingController extends Controller
{
    private BookingModel     $bookingModel;
    private ScheduleModel    $scheduleModel;
    private BusinessServices $businessServices;

    private const ALLOWED_STATUSES = [
        'Admin Approved',
        'In Progress',
        'Completed',
        'Cancelled',
    ];

    public function __construct()
    {
        $this->bookingModel     = new BookingModel();
        $this->scheduleModel    = new ScheduleModel();
        $this->businessServices = new BusinessServices();
    }

    // -------------------------------------------------------------------------
    // Customer
    // -------------------------------------------------------------------------

    public function showAllBookingByCustomer(): void
    {
        $user = Auth::user('customer');

        $this->view('customer.ShowAllBooking', [
            'user'     => $user,
            'bookings' => $this->bookingModel->getBookingByCustomerId($user['id']),
        ]);
    }

    public function detailBookingByCustomer(string $id): void
    {
        $this->view('customer.DetailBooking', [
            'booking' => $this->bookingModel->findBooking((int) $id),
        ]);
    }

    public function createView(): void
    {
        $user = Auth::user('customer');

        $this->view('customer.CreateBooking', [
            'schedule' => $this->scheduleModel->getBusinessHours(),
            'user'     => $user,
        ]);
    }

    public function createBooking(): void
    {
        $result = $this->businessServices->createBooking($this->buildBookingPayload());

        if (!$result['success']) {
            $this->abort('error', $result['message'], '/create-booking');
        }

        $this->abort('success', 'Booking berhasil dibuat.', '/history-booking');
    }

    public function updateViewByCustomer(string $id): void
    {
        $booking = $this->authorizeCustomerBooking($id);

        $this->view('customer.EditBooking', [
            'schedule' => $this->scheduleModel->getBusinessHours() ?: [],
            'booking'  => $booking,
        ]);
    }

    public function updateBookingByCustomer(string $id): void
    {
        $this->authorizeCustomerBooking($id);

        $result = $this->businessServices->updateBooking((int) $id, $this->buildBookingPayload());

        if (!$result['success']) {
            $this->abort('error', $result['message'], "/edit-booking/{$id}");
        }

        $this->abort('success', 'Booking berhasil diperbarui.', "/detail-booking/{$id}");
    }

    public function cancelBooking(string $id): void
    {
        $this->authorizeCustomerBooking($id);

        $this->bookingModel->updateStatus((int) $id, 'Cancelled');
        $this->abort('success', 'Booking berhasil dibatalkan.', '/history-booking');
    }

    // -------------------------------------------------------------------------
    // Admin
    // -------------------------------------------------------------------------

    public function showAllBookingByAdmin(): void
    {
        $this->view('admin.ShowAllBooking', [
            'bookings' => $this->bookingModel->getAllBookings(),
        ]);
    }

    public function detailBookingByAdmin(string $id): void
    {
        $this->view('admin.DetailBooking', [
            'booking' => $this->bookingModel->findBooking((int) $id),
        ]);
    }

    public function updateStatusBookingByAdmin(string $id): void
    {
        $status = $this->input(['status'])['status'];

        if (!in_array($status, self::ALLOWED_STATUSES, strict: true)) {
            $this->abort('error', 'Status tidak valid.', "/admin/detail-booking/{$id}");
        }

        $this->bookingModel->updateStatus((int) $id, $status);
        $this->abort('success', 'Status booking diperbarui.', '/admin/daftar-booking');
    }

    public function deleteBooking(string $id): void
    {
        if (!$this->bookingModel->findBooking((int) $id)) {
            $this->abort('error', 'Booking tidak ditemukan.', '/admin/daftar-booking');
        }

        $this->bookingModel->deleteBooking((int) $id);
        $this->abort('success', 'Booking berhasil dihapus.', '/admin/daftar-booking');
    }

    public function deleteCancelledByAdmin(): void
    {
        $deleted = $this->bookingModel->deleteCancelledBookings();
        $this->abort('success', "Berhasil menghapus {$deleted} booking yang dibatalkan.", '/admin/daftar-booking');
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Validasi kepemilikan booking oleh customer yang sedang login + status harus Pending.
     * Jika gagal, langsung abort (redirect + exit). Jika lolos, return $booking.
     */
    private function authorizeCustomerBooking(string $id): array
    {
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            $this->abort('error', 'Booking tidak ditemukan.', '/history-booking');
        }

        if ($booking['progress_status'] !== 'Pending') {
            $this->abort('error', 'Hanya booking dengan status Pending yang bisa diubah.', '/history-booking');
        }

        return $booking;
    }

    /**
     * Bangun payload booking dari input form + data customer yang sedang login.
     */
    private function buildBookingPayload(): array
    {
        $data = $this->input([
            'phone', 'address', 'vehicle_type', 'model_year',
            'plate_number', 'customer_complaint', 'date', 'checkin_time',
        ]);

        return array_merge($data, [
            'customer_id'  => Auth::user('customer')['id'],
            'booking_date' => $data['date'],
        ]);
    }
}