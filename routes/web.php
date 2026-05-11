<?php

use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\BookingAdminController;
use App\Controllers\Admin\CustomerAdminController;
use App\Controllers\Admin\ScheduleController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Customer\BookingController;
use App\Controllers\Customer\CustomerController;
use App\Controllers\HomeController;
use App\Core\Router;

Router::get('/', [HomeController::class, 'index']);

// Auth
Router::get('/register',    [RegisterController::class, 'index'],    'guest');
Router::post('/register',   [RegisterController::class, 'register'], 'guest');
Router::get('/login',       [LoginController::class, 'index'],       'guest');
Router::post('/login',      [LoginController::class, 'login'],       'guest');
Router::post('/logout',     [LoginController::class, 'logout']);

// Admin
Router::get('/admin',                            [AdminController::class,         'index'],            'admin');
Router::get('/admin/booking',                    [BookingAdminController::class,  'ShowAllBooking'],   'admin');
Router::post('/admin/booking/:id/status',        [BookingAdminController::class,  'updateStatus'],     'admin');
Router::post('/admin/booking/:id/delete',        [BookingAdminController::class,  'delete'],           'admin');
Router::post('/admin/booking/delete-cancelled',  [BookingAdminController::class,  'deleteCancelled'],  'admin');
Router::get('/admin/customer',                   [CustomerAdminController::class, 'ShowAllCustomer'],  'admin');
Router::get('/admin/jadwal',                     [ScheduleController::class,      'index'],            'admin');
Router::post('/admin/jadwal',                    [ScheduleController::class,      'storeAndUpdate'],   'admin');

// Customer
Router::get('/dashboard',           [CustomerController::class, 'index'],    'customer');
Router::get('/create',              [BookingController::class,  'index'],    'customer');
Router::post('/create',             [BookingController::class,  'store'],    'customer');
Router::get('/edit/:id',           [BookingController::class,  'updateView'],   'customer');
Router::post('/edit/:id',          [BookingController::class,  'update'],   'customer');
Router::get('/history',             [BookingController::class,  'ShowAllBooking'],  'customer');
Router::post('/booking/:id/cancel', [BookingController::class,  'cancel'],   'customer');
