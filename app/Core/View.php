<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        $path = str_replace('.', '/', $view);
        $file = __DIR__ . '/../Views/' . $path . '.php';

        if (!file_exists($file)) {
            View::render('error.404');
            return;
        }

        extract($data);
        require $file;
    }
}
