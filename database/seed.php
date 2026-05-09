<?php

use Database\Seeders\DatabaseSeeder;

require __DIR__ . '/../vendor/autoload.php';

$dsn = "mysql:host=localhost;dbname=autohub_fix;charset=utf8mb4";

try {
    $db = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed.' . $e->getMessage());
}

$seeder = new DatabaseSeeder($db);
$seeder->run();

echo 'Database seeded successfully.';