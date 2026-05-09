<?php

namespace App\Controllers\Auth;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Models\UserModel;

class LoginController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index(): void
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
            $this->redirect('/admin');
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
