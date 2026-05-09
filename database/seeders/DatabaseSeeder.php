<?php

namespace Database\Seeders;

use App\Core\Database;

class DatabaseSeeder
{
    public static function run(): void
    {
        $db = Database::connect();

        // Admin
        $db->prepare(
            "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)"
        )->execute([
            'Administrator',
            'admin@autohub.com',
            password_hash('password123', PASSWORD_DEFAULT),
            'admin',
        ]);

        // Customer contoh
        $db->prepare(
            "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)"
        )->execute([
            'Budi Santoso',
            'budi@example.com',
            password_hash('password123', PASSWORD_DEFAULT),
            'customer',
        ]);

        // Jadwal operasional default
        // $db->prepare(
        //     "INSERT INTO business_hours (slot_capacity, open_time, close_time, updated_by) VALUES (?, ?, ?, ?)"
        // )->execute([10, '08:00:00', '17:00:00', 1]);

        echo "Seeder selesai.\n";
    }
}
