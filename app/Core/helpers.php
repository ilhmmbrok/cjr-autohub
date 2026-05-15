<?php

use App\Core\Session;

/**
 * Escape output untuk mencegah XSS.
 * Wajib dipakai di semua view: <?= e($variable) ?>
 */
if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

/**
 * Generate CSRF hidden field untuk form.
 */
if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $token = Session::getCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
    }
}
