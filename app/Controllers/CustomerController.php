<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\BookingModel;
use App\Models\ScheduleModel;

class CustomerController extends Controller
{
    private BookingModel  $bookingModel;
    private ScheduleModel $scheduleModel;

    public function __construct()
    {
        $this->bookingModel  = new BookingModel();
        $this->scheduleModel = new ScheduleModel();
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
}
