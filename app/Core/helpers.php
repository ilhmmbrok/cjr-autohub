<?php

use App\Core\Session;

/**
 * Generate CSRF field for forms.
 */
if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $token = Session::getCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}
