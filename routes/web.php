<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Mail;


// HOME → redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});


// ---------------------------
// USER DASHBOARD
// ---------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});


// ---------------------------
// PROFILE
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ---------------------------
// CUSTOMERS
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::resource('customers', CustomerController::class);
});


// ---------------------------
// SERVICES
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::resource('services', ServiceController::class);
});


// ---------------------------
// INVOICES
// ---------------------------
Route::middleware('auth')->group(function () {

    Route::resource('invoices', InvoiceController::class);

    Route::get('/invoices/{id}/print', 
        [InvoiceController::class, 'print']
    )->name('invoices.print');

    Route::get('/invoices/{id}/pdf', 
        [InvoiceController::class, 'downloadPDF']
    )->name('invoices.pdf');
});


// ---------------------------
// PAYMENTS (placeholder)
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::get('/payments', function () {
        return view('payments.index');
    })->name('payments.index');
});


// ---------------------------
// SETTINGS (placeholder)
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');
});


// ---------------------------
// TEST MAIL
// ---------------------------
Route::get('/test-mail', function () {
    try {
        Mail::raw('Test email from Laravel Mailtrap', function ($message) {
            $message->to('test@example.com')->subject('Testing Mailtrap');
        });
        return "Sent!";
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});


// ---------------------------
// ADMIN PANEL (Simple version)
// ---------------------------
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // SIMPLE ADMIN DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ADMIN USERS MANAGEMENT
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });


// AUTH ROUTES
require __DIR__.'/auth.php';
