<?php

namespace App\Core;

class Auth
{
    public static function login(string $role, array $userData): void
    {
        Session::regenerate();
        Session::setAuth($role, [
            'id'       => $userData['id'],
            'fullname' => $userData['fullname'],
            'email'    => $userData['email'],
        ]);
    }

    public static function logout(string $role): void
    {
        Session::removeAuth($role);
    }

    public static function check(string $role): bool
    {
        return Session::isLoggedIn($role);
    }

    public static function user(string $role): ?array
    {
        return Session::getAuth($role);
    }

    public static function role(): ?string
    {
        if (Session::isLoggedIn('admin')) {
            return 'admin';
        }
        if (Session::isLoggedIn('customer')) {
            return 'customer';
        }
        return null;
    }
}
