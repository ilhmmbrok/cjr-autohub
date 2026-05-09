<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\BookingModel;
use App\Models\ScheduleModel;

class AdminController extends Controller
{
    private BookingModel $bookingModel;
    private ScheduleModel $scheduleModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->scheduleModel = new ScheduleModel();
    }

    public function index()
    {
        $schedule = $this->scheduleModel->getBusinessHours();
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
        $stats     = $this->bookingModel->countByStatus();
        $chartData = $this->bookingModel->getMonthlyStats((int) date('Y'));

        $this->view('admin.Dashboard', [
            'totalPending'    => $stats['Pending'],
            'totalInProgress' => $stats['In Progress'],
            'totalCompleted'  => $stats['Completed'],
            'chartData'       => $chartData,
            'schedule' => $schedule ?: [],
            'slotInfo' => $slotInfo
        ]);
    }
}
