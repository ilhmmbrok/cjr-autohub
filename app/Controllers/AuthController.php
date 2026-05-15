<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\UserModel;

class AuthController extends Controller
{
    private UserModel $userModel;

    // Maksimal percobaan login & durasi lockout (detik)
    private const LOGIN_MAX_ATTEMPTS = 5;
    private const LOGIN_LOCKOUT_TTL  = 300; // 5 menit

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function registerView(): void
    {
        $this->view('auth.register');
    }

    public function register(): void
    {
        ['fullname' => $fullname, 'email' => $email, 'password' => $password]
            = $this->input(['fullname', 'email', 'password']);

        if (empty($fullname) || empty($email) || empty($password)) {
            $this->abort('error', 'Please fill in all fields.', '/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->abort('error', 'Invalid email format.', '/register');
        }

        if (strlen($password) < 8) {
            $this->abort('error', 'Password must be at least 8 characters.', '/register');
        }

        if ($this->userModel->findByEmail($email)) {
            $this->abort('error', 'Email already exists.', '/register');
        }

        $this->userModel->create([
            'fullname' => $fullname,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'customer',
        ]);

        $this->abort('success', 'Registration successful. Please login.', '/login');
    }

    public function loginView(): void
    {
        $this->view('auth.login');
    }

    public function login(): void
    {
        // Rate limiting berbasis session
        $this->checkLoginRateLimit();

        ['email' => $email, 'password' => $password]
            = $this->input(['email', 'password']);

        if (empty($email) || empty($password)) {
            $this->abort('error', 'Please fill in all fields.', '/login');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->incrementLoginAttempts();
            $this->abort('error', 'Invalid email or password.', '/login');
        }

        // Login berhasil — reset counter
        $this->resetLoginAttempts();
        Auth::login($user['role'], $user);

        $this->redirect($user['role'] === 'admin' ? '/admin/dashboard' : '/dashboard');
    }

    public function logout(): void
    {
        $role = Auth::role();
        if ($role) {
            Auth::logout($role);
        }

        $this->abort('success', 'Logout successful.', '/login');
    }

    // -------------------------------------------------------------------------
    // Rate limiting helpers
    // -------------------------------------------------------------------------

    private function checkLoginRateLimit(): void
    {
        $attempts    = $_SESSION['login_attempts']    ?? 0;
        $lastAttempt = $_SESSION['login_last_attempt'] ?? 0;
        $elapsed     = time() - $lastAttempt;

        if ($attempts >= self::LOGIN_MAX_ATTEMPTS && $elapsed < self::LOGIN_LOCKOUT_TTL) {
            $wait = self::LOGIN_LOCKOUT_TTL - $elapsed;
            $this->abort('error', "Terlalu banyak percobaan login. Coba lagi dalam {$wait} detik.", '/login');
        }

        // Reset otomatis jika lockout sudah lewat
        if ($elapsed >= self::LOGIN_LOCKOUT_TTL) {
            $this->resetLoginAttempts();
        }
    }

    private function incrementLoginAttempts(): void
    {
        $_SESSION['login_attempts']    = ($_SESSION['login_attempts'] ?? 0) + 1;
        $_SESSION['login_last_attempt'] = time();
    }

    private function resetLoginAttempts(): void
    {
        unset($_SESSION['login_attempts'], $_SESSION['login_last_attempt']);
    }
}
