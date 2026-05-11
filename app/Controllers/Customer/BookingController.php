<?php

namespace App\Controllers\Customer;

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

    public function index(): void
    {
        $this->view('customer.CreateBooking');
    }

    public function ShowAllBooking(): void
    {
        $user     = Auth::user('customer');
        $bookings = $this->bookingModel->getBookingByCustomerId($user['id']);

        $this->view('customer.ShowAllBooking', [
            'user'     => $user,
            'bookings' => $bookings,
        ]);
    }

    public function show(string $id): void
    {
        $booking = $this->bookingModel->findBooking((int) $id);
        $this->view('customer.DetailBooking', [
            'booking' => $booking,
        ]);
    }

    public function store(): void
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
            $this->redirect('/create');
            return;
        }

        Session::setMessage('success', 'Booking berhasil dibuat.');
        $this->redirect('/create');
    }

    public function cancel(string $id): void
    {
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/history');
            return;
        }

        if ($booking['progress_status'] !== 'Pending') {
            Session::setMessage('error', 'Hanya booking dengan status Pending yang bisa dibatalkan.');
            $this->redirect('/history');
            return;
        }

        $this->bookingModel->updateStatus((int) $id, 'Cancelled');
        Session::setMessage('success', 'Booking berhasil dibatalkan.');
        $this->redirect('/history');
    }

    public function updateView(string $id): void
    {
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/history');
            return;
        }

        if ($booking['progress_status'] !== 'Pending') {
            Session::setMessage('error', 'Hanya booking dengan status Pending yang bisa diubah.');
            $this->redirect('/history');
            return;
        }

        $this->view('customer.EditBooking', [
            'booking' => $booking,
        ]);
    }

    public function update(string $id): void
    {
        $user    = Auth::user('customer');
        $booking = $this->bookingModel->findBooking((int) $id);

        if (!$booking || (int) $booking['customer_id'] !== (int) $user['id']) {
            Session::setMessage('error', 'Booking tidak ditemukan.');
            $this->redirect('/history');
            return;
        }

        if ($booking['progress_status'] !== 'Pending') {
            Session::setMessage('error', 'Hanya booking dengan status Pending yang bisa diubah.');
            $this->redirect('/history');
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
            $this->redirect("/booking/{$id}/update");
            return;
        }

        Session::setMessage('success', 'Booking berhasil diperbarui.');
        $this->redirect('/history');
    }
}
