<?php

namespace App\Core;

class App
{
    public static function run(): void
    {
        self::setSecurityHeaders();

        Session::start();

        require __DIR__ . '/../../routes/web.php';
        Router::dispatch();
    }

    private static function setSecurityHeaders(): void
    {
        // Anti clickjacking
        header('X-Frame-Options: DENY');
        // Anti MIME-type sniffing
        header('X-Content-Type-Options: nosniff');
        // Batasi referrer info
        header('Referrer-Policy: strict-origin-when-cross-origin');
        // Content Security Policy — disesuaikan untuk CDN yang dipakai
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.bunny.net; img-src 'self' data:; font-src 'self' https://fonts.bunny.net");
        // Matikan XSS auditor lama (modern browser sudah pakai CSP)
        header('X-XSS-Protection: 0');
    }
}
