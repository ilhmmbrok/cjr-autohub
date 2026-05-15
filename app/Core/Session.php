<?php

namespace App\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            return;
        }

        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);

        // Secure cookie flags
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => false,  // set true jika sudah HTTPS
            'httponly'  => true,   // tidak bisa diakses JavaScript
            'samesite'  => 'Lax', // proteksi CSRF tambahan
        ]);

        session_start();

        // Flash message: geser ke slot "old" agar tersedia di request berikutnya
        if (isset($_SESSION['message'])) {
            $_SESSION['message_old'] = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            unset($_SESSION['message_old']);
        }

        self::generateCsrfToken();
    }

    // CSRF token di-regenerate setelah session baru
    public static function regenerate(): void
    {
        session_regenerate_id(true);
        unset($_SESSION['csrf_token']);
        self::generateCsrfToken();
    }

    // -------------------------------------------------------------------------
    // Auth
    // -------------------------------------------------------------------------

    public static function setAuth(string $role, array $userData): void
    {
        $_SESSION["auth_$role"] = $userData;
    }

    public static function getAuth(string $role): ?array
    {
        return $_SESSION["auth_$role"] ?? null;
    }

    public static function removeAuth(string $role): void
    {
        unset($_SESSION["auth_$role"]);
    }

    public static function isLoggedIn(string $role): bool
    {
        return isset($_SESSION["auth_$role"]);
    }

    // -------------------------------------------------------------------------
    // Flash messages
    // -------------------------------------------------------------------------

    public static function setMessage(string $key, string $message): void
    {
        $_SESSION['message'][$key] = $message;
    }

    public static function getMessage(string $key): ?string
    {
        return $_SESSION['message_old'][$key] ?? null;
    }

    // -------------------------------------------------------------------------
    // CSRF
    // -------------------------------------------------------------------------

    public static function generateCsrfToken(): void
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function getCsrfToken(): string
    {
        self::generateCsrfToken();
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(?string $token): bool
    {
        return $token && isset($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}
