<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Models\BookingModel;

class BookingAdminController extends Controller
{
    private BookingModel $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    public function ShowAllBooking(): void
    {
        $bookings = $this->bookingModel->getAllBookings();
        $this->view('admin.ShowAllBooking', [
            'bookings' => $bookings
        ]);
    }

    public function updateStatus(string $id): void
    {
        $status  = trim($_POST['status'] ?? '');
        $allowed = [
            'Admin Approved',
            'In Progress',
            'Completed',
            'Cancelled'
        ];

        if (!in_array($status, $allowed)) {
            Session::setMessage('error', 'Status tidak valid.');
            $this->redirect('/admin/booking');
            return;
        }

        $this->bookingModel->updateStatus((int) $id, $status);
        Session::setMessage('success', 'Status booking diperbarui.');
        $this->redirect('/admin/booking');
    }

    public function delete(string $id): void
    {
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/admin/booking');
            return;
        }

        $this->bookingModel->deleteBooking((int) $id);
        Session::setMessage('success', 'Booking berhasil dihapus.');
        $this->redirect('/admin/booking');
    }

    public function deleteCancelled(): void
    {
        $deleted = $this->bookingModel->deleteCancelledBookings();
        Session::setMessage('success', "Berhasil menghapus {$deleted} booking yang dibatalkan.");
        $this->redirect('/admin/booking');
    }
}
