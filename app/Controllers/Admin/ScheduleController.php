<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\ScheduleModel;

class ScheduleController extends Controller
{
    private ScheduleModel $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
    }

    public function index(): void
    {
        $schedule = $this->scheduleModel->getBusinessHours();
        $this->view('admin.CreateUpdateSchedule', [
            'schedule' => $schedule ?: [],
        ]);
    }

    public function storeAndUpdate(): void
    {
        $slotCapacity = (int) trim($_POST['slot_capacity'] ?? 0);
        $openTime     = trim($_POST['open_time']  ?? '');
        $closeTime    = trim($_POST['close_time'] ?? '');

        if ($slotCapacity < 1 || $slotCapacity > 100) {
            Session::setMessage('error', 'Kuota slot harus antara 1 – 100.');
            $this->redirect('/admin/jadwal');
            return;
        }

        if (!preg_match('/^\d{2}:\d{2}$/', $openTime) || !preg_match('/^\d{2}:\d{2}$/', $closeTime)) {
            Session::setMessage('error', 'Format jam tidak valid.');
            $this->redirect('/admin/jadwal');
            return;
        }

        if ($openTime >= $closeTime) {
            Session::setMessage('error', 'Jam buka harus lebih awal dari jam tutup.');
            $this->redirect('/admin/jadwal');
            return;
        }

        $admin    = Auth::user('admin');
        $existing = $this->scheduleModel->getBusinessHours();

        if ($existing) {
            $this->scheduleModel->updateBusinessHours([
                'slot_capacity' => $slotCapacity,
                'open_time'     => $openTime . ':00',
                'close_time'    => $closeTime . ':00',
                'updated_by'    => $admin['id'],
                'id'            => $existing['id'],
            ]);
        } else {
            $this->scheduleModel->createBusinessHours([
                'slot_capacity' => $slotCapacity,
                'open_time'     => $openTime . ':00',
                'close_time'    => $closeTime . ':00',
                'updated_by'    => $admin['id'],
            ]);
        }

        Session::setMessage('success', 'Jadwal operasional berhasil disimpan.');
        $this->redirect('/admin/jadwal');
    }
}
