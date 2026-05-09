<?php

namespace App\Core;

class App
{
    public static function run(): void
    {
        Session::start();
        require __DIR__ . '/../../routes/web.php';
        Router::dispatch();
    }
}
