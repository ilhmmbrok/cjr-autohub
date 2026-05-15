<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Session;

class RoleMiddleware
{
    public static function handle(?string $role): void
    {
        match ($role) {
            'admin' => self::requireRole('admin', '/login', 'You are not authorized to access this page.'),
            'customer' => self::requireRole('customer', '/login', 'Please login first.'),
            'guest' => self::redirectIfLoggedIn(),
            default => null,
        };
    }

    private static function requireRole(string $role, string $redirectTo, string $message): void
    {
        if (!Auth::check($role)) {
            Session::setMessage('error', $message);
            header("Location: $redirectTo");
            exit;
        }
    }

    private static function redirectIfLoggedIn(): void
    {
        if (Auth::check('admin')) {
            header('Location: /admin/dashboard');
            exit;
        }

        if (Auth::check('customer')) {
            header('Location: /dashboard');
            exit;
        }
    }
}