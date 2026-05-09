<?php

namespace App\Models;

use App\Core\Database;

class ScheduleModel
{
    protected $table = 'business_hours';

    public function getBusinessHours(): array|false
    {
        return Database::fetch("SELECT * FROM business_hours LIMIT 1");
    }

    public function createBusinessHours(array $data): int
    {
        return Database::execute(
            "INSERT INTO business_hours (slot_capacity, open_time, close_time, updated_by)
             VALUES (?, ?, ?, ?)",
            [
                $data['slot_capacity'],
                $data['open_time'],
                $data['close_time'],
                $data['updated_by']
            ]
        );
    }

    public function updateBusinessHours(array $data): int
    {
        return Database::execute(
            "UPDATE business_hours
             SET slot_capacity = ?, open_time = ?, close_time = ?, updated_by = ?
             WHERE id = ?",
            [
                $data['slot_capacity'],
                $data['open_time'],
                $data['close_time'],
                $data['updated_by'],
                $data['id']
            ]
        );
    }
}
