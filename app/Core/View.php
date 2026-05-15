<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        $path = str_replace('.', '/', $view);
        $file = __DIR__ . '/../Views/' . $path . '.php';

        if (!file_exists($file)) {
            // Hindari infinite loop jika 404 view juga tidak ada
            if ($view !== 'error.404') {
                self::render('error.404');
            }
            return;
        }

        // EXTR_SKIP agar variable lokal tidak bisa di-override
        extract($data, EXTR_SKIP);
        require $file;
    }
}
