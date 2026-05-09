<?php

namespace App\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.use_only_cookies', 1);  // Hanya gunakan cookie (bukan URL)
            ini_set('session.use_strict_mode', 1);   // Tolak session ID yang tidak valid

            session_start();

            if (isset($_SESSION['message'])) {
                $_SESSION['message_old'] = $_SESSION['message'];
                unset($_SESSION['message']);
            } else {
                unset($_SESSION['message_old']);
            }
        }
    }
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }
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
    public static function setMessage(string $key, string $message): void
    {
        $_SESSION['message'][$key] = $message;
    }
    public static function getMessage(string $key): ?string
    {
        return $_SESSION['message_old'][$key] ?? null;
    }
    public static function destroy(): void
    {
        session_destroy();
    }
}
