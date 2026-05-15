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
                'Administrator 2',
                'admin2@autohub.com',
                null,
                password_hash('@AdminAutohub', PASSWORD_DEFAULT),
                'admin'
            ]
        );
        Database::execute(
            "INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?)",
            [
                'Administrator',
                'admin@autohub.com',
                null,
                password_hash('@AdminAutohub', PASSWORD_DEFAULT),
                'admin'
            ]
        );

        echo "Seeder selesai.\n";
    }
}
