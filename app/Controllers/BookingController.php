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

    public function __construct()
    {
        $this->bookingModel     = new BookingModel();
        $this->scheduleModel    = new ScheduleModel();
        $this->businessServices = new BusinessServices();
    }

    public function ShowAllBookingByCustomer(): void
    {
        $user     = Auth::user('customer');
        $bookings = $this->bookingModel->getBookingByCustomerId($user['id']);

        $this->view('customer.ShowAllBooking', [
            'user'     => $user,
            'bookings' => $bookings,
        ]);
    }
    public function showAllBookingByAdmin(): void
    {
        $bookings = $this->bookingModel->getAllBookings();
        $this->view('admin.ShowAllBooking', [
            'bookings' => $bookings
        ]);
    }

    public function detailBookingByCustomer(string $id): void
    {
        $booking = $this->bookingModel->findBooking((int) $id);
        $this->view('customer.DetailBooking', [
            'booking' => $booking,
        ]);
    }
    public function detailBookingByAdmin(string $id): void
    {
        $booking = $this->bookingModel->findBooking((int) $id);
        $this->view('admin.DetailBooking', [
            'booking' => $booking,
        ]);
    }

    public function createView(): void
    {
        $this->view('customer.CreateBooking');
    }

    public function createBooking(): void
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

        $result = $this->businessServices->createBooking(array_merge($data, [
            'customer_id'  => Auth::user('customer')['id'],
            'booking_date' => $data['date'],
        ]));

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
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/history-booking');
            return;
        }

        if ($booking['progress_status'] !== 'Pending') {
            Session::setMessage('error', 'Hanya booking dengan status Pending yang bisa diubah.');
            $this->redirect('/history-booking');
            return;
        }

        $this->view('customer.EditBooking', [
            'booking' => $booking,
        ]);
    }
    public function updateBookingByCustomer(string $id): void
    {
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/history-booking');
            return;
        }

        if ($booking['progress_status'] !== 'Pending') {
            Session::setMessage('error', 'Hanya booking dengan status Pending yang bisa diubah.');
            $this->redirect('/history-booking');
            return;
        }

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

        $result = $this->businessServices->updateBooking((int) $id, array_merge($data, [
            'customer_id'  => Auth::user('customer')['id'],
            'booking_date' => $data['date'],
        ]));

        if (!$result['success']) {
            Session::setMessage('error', $result['message']);
            $this->redirect("/edit-booking/{$id}");
            return;
        }

        Session::setMessage('success', 'Booking berhasil diperbarui.');
        $this->redirect('/history-booking');
    }
    public function updateStatusBookingByAdmin(string $id): void
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
            $this->redirect("/admin/detail-booking/{$id}");
            return;
        }

        $this->bookingModel->updateStatus((int) $id, $status);
        Session::setMessage('success', 'Status booking diperbarui.');
        $this->redirect('/admin/daftar-booking');
        return;
    }
    public function cancelBooking(string $id): void
    {
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/history-booking');
            return;
        }

        if ($booking['progress_status'] !== 'Pending') {
            Session::setMessage('error', 'Hanya booking dengan status Pending yang bisa dibatalkan.');
            $this->redirect('/history-booking');
            return;
        }

        $this->bookingModel->updateStatus((int) $id, 'Cancelled');
        Session::setMessage('success', 'Booking berhasil dibatalkan.');
        $this->redirect('/history-booking');
    }
    public function deleteBooking(int $id): void
    {
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/admin/daftar-booking');
            return;
        }

        $this->bookingModel->deleteBooking((int) $id);
        Session::setMessage('success', 'Booking berhasil dihapus.');
        $this->redirect('/admin/daftar-booking');
        return;
    }

    public function deleteCancelledByAdmin(): void
    {
        $deleted = $this->bookingModel->deleteCancelledBookings();
        Session::setMessage('success', "Berhasil menghapus {$deleted} booking yang dibatalkan.");
        $this->redirect('/admin/daftar-booking');
        return;
    }
}
