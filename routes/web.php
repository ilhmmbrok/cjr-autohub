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
Router::group(['middleware' => 'guest'], function () {
    Router::get('/register', [AuthController::class, 'registerView']);
    Router::post('/register', [AuthController::class, 'register']);
    Router::get('/login', [AuthController::class, 'loginView']);
    Router::post('/login', [AuthController::class, 'login']);
});

Router::post('/logout', [AuthController::class, 'logout']);

// Admin
Router::group(['middleware' => 'admin'], function () {
    Router::get('/admin/dashboard', [AdminController::class, 'adminDashboard']);
    
    Router::get('/admin/daftar-booking', [BookingController::class, 'showAllBookingByAdmin']);
    Router::get('/admin/detail-booking/:id', [BookingController::class, 'detailBookingByAdmin']);
    Router::post('/admin/daftar-booking/:id/status', [BookingController::class, 'updateStatusBookingByAdmin']);
    Router::post('/admin/daftar-booking/:id/delete', [BookingController::class, 'deleteBooking']);
    Router::post('/admin/daftar-booking/delete-cancelled', [BookingController::class, 'deleteCancelledByAdmin']);
    
    Router::get('/admin/jadwal', [ScheduleController::class, 'scheduleView']);
    Router::post('/admin/jadwal/create-update', [ScheduleController::class, 'createUpdateSchedule']);

    Router::get('/admin/profile', [AdminController::class, 'profileView']);
    Router::post('/admin/profile', [AdminController::class, 'updateProfile']);
    Router::post('/admin/profile/password', [AdminController::class, 'updatePassword']);
});

// Customer
Router::group(['middleware' => 'customer'], function () {
    Router::get('/dashboard', [CustomerController::class, 'customerDashboard']);
    
    Router::get('/history-booking', [BookingController::class, 'showAllBookingByCustomer']);
    Router::get('/detail-booking/:id', [BookingController::class, 'detailBookingByCustomer']);
    Router::post('/history-booking/:id/cancel', [BookingController::class, 'cancelBooking']);
    
    Router::get('/create-booking', [BookingController::class, 'createView']);
    Router::post('/create-booking', [BookingController::class, 'createBooking']);
    
    Router::get('/edit-booking/:id', [BookingController::class, 'updateViewByCustomer']);
    Router::post('/edit-booking/:id', [BookingController::class, 'updateBookingByCustomer']);

    // Profile
    Router::get('/profile', [CustomerController::class, 'profileView']);
    Router::post('/profile', [CustomerController::class, 'updateProfile']);
    Router::post('/profile/password', [CustomerController::class, 'updatePassword']);
});
