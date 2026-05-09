<?php

namespace App\Controllers\Customer;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\BookingModel;
use App\Models\ScheduleModel;

class CustomerController extends Controller
{
    private BookingModel $bookingModel;
    private ScheduleModel $scheduleModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->scheduleModel = new ScheduleModel();
    }

    public function index(): void
    {
        $user = Auth::user('customer');
        $schedule = $this->scheduleModel->getBusinessHours();

        // Hitung sisa slot untuk hari ini saja
        $slotInfo = [];
        if ($schedule) {
            $maxSlot = (int) $schedule['slot_capacity'];
            $date    = date('Y-m-d');
            $booked  = $this->bookingModel->countBookingsByDate($date);
            $slotInfo[] = [
                'date'      => $date,
                'booked'    => $booked,
                'available' => max(0, $maxSlot - $booked),
                'max'       => $maxSlot,
            ];
        }

        $bookings = $this->bookingModel->getBookingByCustomerId($user['id']);
        $stats    = $this->bookingModel->countByStatus($user['id']);

        $this->view('customer.Dashboard', [
            'user'            => $user,
            'bookings'        => $bookings,
            'totalPending'    => $stats['Pending'],
            'totalInProgress' => $stats['In Progress'],
            'totalCompleted'  => $stats['Completed'],
            'schedule' => $schedule ?: [],
            'slotInfo' => $slotInfo,
        ]);
    }
}
