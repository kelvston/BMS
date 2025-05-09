<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/sales/create', [InvoiceController::class, 'createQuickSale'])
    ->name('sales.create')
    ->middleware('auth');
// Resource Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
     ->middleware('auth')
     ->name('dashboard');

    // User Management
    Route::resource('users', UserController::class)->middleware('role:admin');

    // Customer Management
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);

    // Invoice Management
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.pdf');
    Route::post('/invoices/{invoice}/paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.paid');

    // Other resources...
});
