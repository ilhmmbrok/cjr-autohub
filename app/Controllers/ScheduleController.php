<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\ScheduleModel;

class ScheduleController extends Controller
{
    private ScheduleModel $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
    }

    public function scheduleView(): void
    {
        $this->view('admin.CreateUpdateSchedule', [
            'schedule' => $this->scheduleModel->getBusinessHours() ?: [],
        ]);
    }

    public function createUpdateSchedule(): void
    {
        ['slot_capacity' => $slotRaw, 'open_time' => $openTime, 'close_time' => $closeTime]
            = $this->input(['slot_capacity', 'open_time', 'close_time']);

        $slotCapacity = (int) $slotRaw;
        $redirect     = '/admin/jadwal';

        if ($slotCapacity < 1 || $slotCapacity > 100) {
            $this->abort('error', 'Kuota slot harus antara 1 – 100.', $redirect);
        }

        $timePattern = '/^\d{2}:\d{2}$/';
        if (!preg_match($timePattern, $openTime) || !preg_match($timePattern, $closeTime)) {
            $this->abort('error', 'Format jam tidak valid.', $redirect);
        }

        if ($openTime >= $closeTime) {
            $this->abort('error', 'Jam buka harus lebih awal dari jam tutup.', $redirect);
        }

        $payload  = [
            'slot_capacity' => $slotCapacity,
            'open_time'     => $openTime . ':00',
            'close_time'    => $closeTime . ':00',
            'updated_by'    => Auth::user('admin')['id'],
        ];
        $existing = $this->scheduleModel->getBusinessHours();

        if ($existing) {
            $this->scheduleModel->updateBusinessHours(array_merge($payload, ['id' => $existing['id']]));
        } else {
            $this->scheduleModel->createBusinessHours($payload);
        }

        $this->abort('success', 'Jadwal operasional berhasil disimpan.', $redirect);
    }
}
