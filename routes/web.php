<?php

use App\Controllers\ScheduleController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\BookingController;
use App\Controllers\CustomerController;
use App\Controllers\HomeController;
use App\Core\Router;

Router::get('/', [HomeController::class, 'index']);

// Auth
Router::get(
    '/register',
    [AuthController::class, 'registerView'],
    'guest'
);
Router::post(
    '/register',
    [AuthController::class, 'register'],
    'guest'
);
Router::get(
    '/login',
    [AuthController::class, 'loginView'],
    'guest'
);
Router::post(
    '/login',
    [AuthController::class, 'login'],
    'guest'
);
Router::post(
    '/logout',
    [AuthController::class, 'logout']
);

// Admin
Router::get(
    '/admin/dashboard',
    [AdminController::class,   'adminDashboard'],
    'admin'
);
Router::get(
    '/admin/daftar-booking',
    [BookingController::class, 'showAllBookingByAdmin'],
    'admin'
);
Router::post(
    '/admin/daftar-booking/:id/status',
    [BookingController::class, 'updateStatusBookingByAdmin'],
    'admin'
);
Router::post(
    '/admin/daftar-booking/:id/delete',
    [BookingController::class, 'deleteBooking'],
    'admin'
);
Router::post(
    '/admin/daftar-booking/delete-cancelled',
    [BookingController::class, 'deleteCancelledByAdmin'],
    'admin'
);
Router::get(
    '/admin/jadwal',
    [ScheduleController::class, 'scheduleView'],
    'admin'
);
Router::post(
    '/admin/jadwal/create-update',
    [ScheduleController::class, 'createUpdateSchedule'],
    'admin'
);

// Customer
Router::get(
    '/dashboard',
    [CustomerController::class, 'customerDashboard'],
    'customer'
);
Router::get(
    '/history-booking',
    [BookingController::class,  'showAllBookingByCustomer'],
    'customer'
);
Router::get(
    '/detail-booking/:id',
    [BookingController::class,  'detailBookingByCustomer'],
    'customer'
);
Router::get(
    '/create-booking',
    [BookingController::class,  'createView'],
    'customer'
);
Router::post(
    '/create-booking',
    [BookingController::class,  'createBooking'],
    'customer'
);
Router::get(
    '/edit-booking/:id',
    [BookingController::class,  'updateViewByCustomer'],
    'customer'
);
Router::post(
    '/edit-booking/:id',
    [BookingController::class,  'updateBookingByCustomer'],
    'customer'
);
Router::post(
    '/history-booking/:id/cancel',
    [BookingController::class,  'cancelBooking'],
    'customer'
);
