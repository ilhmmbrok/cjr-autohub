<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Session;

class RoleMiddleware
{
    public static function handle(?string $role): void
    {
        if ($role === null) return;

        if ($role === 'admin') {
            if (!Auth::check('admin')) {
                Session::setMessage('error', 'You are not authorized to access this page.');
                header('Location: /login');
                exit;
            }
        }

        if ($role === 'customer') {
            if (!Auth::check('customer')) {
                Session::setMessage('error', 'Please login first.');
                header('Location: /login');
                exit;
            }
        }

        if ($role === 'guest') {
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
}