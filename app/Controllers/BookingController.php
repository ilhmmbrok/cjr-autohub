<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\BookingModel;
use App\Models\ScheduleModel;
use App\Services\BusinessServices;

class BookingController extends Controller
{
    private BookingModel $bookingModel;
    private ScheduleModel $scheduleModel;
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
        $this->view('customer.CreateBooking', [
            'schedule' => $this->scheduleModel->getBusinessHours(),
        ]);
    }

    public function createBooking(): void
    {
        $result = $this->businessServices->createBooking(
            $this->buildBookingPayload()
        );

        if (!$result['success']) {
            Session::setMessage('error', $result['message']);
            $this->redirect('/create-booking');
            return;
        }

        Session::setMessage('success', 'Booking berhasil dibuat.');
        $this->redirect('/history-booking');
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

        $result = $this->businessServices->updateBooking(
            (int) $id,
            $this->buildBookingPayload()
        );

        if (!$result['success']) {
            Session::setMessage('error', $result['message']);
            $this->redirect("/edit-booking/{$id}");
            return;
        }

        Session::setMessage('success', 'Booking berhasil diperbarui.');
        $this->redirect("/detail-booking/{$id}");
    }

    public function cancelBooking(string $id): void
    {
        $this->authorizeCustomerBooking($id);

        $this->bookingModel->updateStatus((int) $id, 'Cancelled');
        Session::setMessage('success', 'Booking berhasil dibatalkan.');
        $this->redirect('/history-booking');
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
            Session::setMessage('error', 'Status tidak valid.');
            $this->redirect("/admin/detail-booking/{$id}");
            return;
        }

        $this->bookingModel->updateStatus((int) $id, $status);
        Session::setMessage('success', 'Status booking diperbarui.');
        $this->redirect('/admin/daftar-booking');
    }

    public function deleteBooking(string $id): void
    {
        if (!$this->bookingModel->findBooking((int) $id)) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/admin/daftar-booking');
            return;
        }

        $this->bookingModel->deleteBooking((int) $id);
        Session::setMessage('success', 'Booking berhasil dihapus.');
        $this->redirect('/admin/daftar-booking');
    }

    public function deleteCancelledByAdmin(): void
    {
        $deleted = $this->bookingModel->deleteCancelledBookings();
        Session::setMessage('success', "Berhasil menghapus {$deleted} booking yang dibatalkan.");
        $this->redirect('/admin/daftar-booking');
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Validasi kepemilikan booking oleh customer + status harus Pending.
     * Langsung redirect & exit jika gagal, return $booking jika lolos.
     */
    private function authorizeCustomerBooking(string $id): array
    {
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/history-booking');
            exit;
        }

        if ($booking['progress_status'] !== 'Pending') {
            Session::setMessage('error', 'Hanya booking dengan status Pending yang bisa diubah.');
            $this->redirect('/history-booking');
            exit;
        }

        return $booking;
    }

    /**
     * Bangun payload booking dari input form + data customer yang sedang login.
     */
    private function buildBookingPayload(): array
    {
        $data = $this->input([
            'phone',
            'address',
            'vehicle_type',
            'model_year',
            'plate_number',
            'customer_complaint',
            'date',
            'checkin_time',
        ]);

        return array_merge($data, [
            'customer_id'  => Auth::user('customer')['id'],
            'booking_date' => $data['date'],
        ]);
    }
}