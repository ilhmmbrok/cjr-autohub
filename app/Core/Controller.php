<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $url): never
    {
        header("Location: $url");
        exit;
    }

    /**
     * Flash pesan lalu redirect — shorthand agar tidak perlu 2 baris di setiap controller.
     */
    protected function abort(string $type, string $message, string $url): never
    {
        Session::setMessage($type, $message);
        $this->redirect($url);
    }

    protected function input(array $fields): array
    {
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = trim($_POST[$field] ?? '');
        }
        return $data;
    }
}
