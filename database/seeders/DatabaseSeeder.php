<?php

namespace Database\Seeders;

use App\Core\Database;

class DatabaseSeeder
{
    public static function run(): void
    {
        Database::execute(
            "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)",
            [
                'eva',
                'eva@example.com',
                password_hash('password123', PASSWORD_DEFAULT),
                'customer'
            ]
        );
        Database::execute(
            "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)",
            [
                'Administrator',
                'admin@autohub.com',
                password_hash('password123', PASSWORD_DEFAULT),
                'admin'
            ]
        );

        echo "Seeder selesai.\n";
    }
}
