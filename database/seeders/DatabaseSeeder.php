<?php

namespace Database\Seeders;

use App\Core\Database;

class DatabaseSeeder
{
    public static function run(): void
    {
        Database::execute(
            "INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?)",
            [
                'Eva Customer',
                'eva@example.com',
                '081234567890',
                password_hash('Eva@2026!', PASSWORD_DEFAULT),
                'customer'
            ]
        );
        Database::execute(
            "INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?)",
            [
                'Administrator',
                'admin@autohub.com',
                null,
                password_hash('Admin@2026!', PASSWORD_DEFAULT),
                'admin'
            ]
        );

        echo "Seeder selesai.\n";
    }
}
