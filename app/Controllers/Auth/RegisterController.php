<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Core\Session;
use App\Models\UserModel;

class RegisterController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index(): void
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
}
