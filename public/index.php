<?php

define('BASE_PATH', dirname(__DIR__));

// Load autoloader
require BASE_PATH . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Run app
\App\Core\App::run();