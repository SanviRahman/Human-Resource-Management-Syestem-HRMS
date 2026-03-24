<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;

// Login Routes
Route::get('/', [AuthenticController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticController::class, 'login'])->name('login.submit');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticController::class, 'logout'])->name('logout');
});

// Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // resourceful route for employee CRUD
        Route::resource('employees', EmployeeController::class)->except(['show', 'create', 'edit', 'index']);
    });

// HR
Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/hr/dashboard', function () {
        return "This is HR Dashboard";
    })->name('hr.dashboard');
});

// User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return "This is normal User Dashboard";
    })->name('dashboard');
});

// Admin + HR
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/reports', function () {
        return "Company Reports (Accessible by Admin and HR)";
    })->name('reports');
});