<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\UserModel;

class CustomerAdminController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function ShowAllCustomer(): void
    {
        $customers = $this->userModel->getAllCustomers();
        $this->view('admin.ShowAllCustomer', [
            'customers' => $customers
        ]);
    }
}
