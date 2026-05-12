<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\UserModel;

class AuthController extends Controller
{
    private UserModel $userModel;

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
        $fullname = trim($_POST['fullname'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';

        if (empty($fullname) || empty($email) || empty($password)) {
            Session::setMessage('error', 'Please fill in all fields.');
            $this->redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::setMessage('error', 'Invalid email format.');
            $this->redirect('/register');
        }

        if (strlen($password) < 8) {
            Session::setMessage('error', 'Password must be at least 8 characters.');
            $this->redirect('/register');
        }

        if ($this->userModel->findByEmail($email)) {
            Session::setMessage('error', 'Email already exists.');
            $this->redirect('/register');
        }

        $this->userModel->create([
            'fullname' => $fullname,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'customer',
        ]);

        Session::setMessage('success', 'Registration successful. Please login.');
        $this->redirect('/login');
    }

    public function loginView(): void
    {
        $this->view('auth.login');
    }

    public function login(): void
    {
        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';

        if (empty($email) || empty($password)) {
            Session::setMessage('error', 'Please fill in all fields.');
            $this->redirect('/login');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            Session::setMessage('error', 'Invalid email or password.');
            $this->redirect('/login');
        }

        Auth::login($user['role'], $user);

        if ($user['role'] === 'admin') {
            $this->redirect('/admin/dashboard');
        }

        $this->redirect('/dashboard');
    }

    public function logout(): void
    {
        $role = Auth::role();
        if ($role) {
            Auth::logout($role);
        }
        Session::setMessage('success', 'Logout successful.');
        $this->redirect('/login');
    }
}
