<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticController;
use App\Http\Controllers\Admin\AdminController;

// Login Routes
Route::get('/', [AuthenticController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticController::class, 'login'])->name('login.submit');
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticController::class, 'logout'])->name('logout');
});



// For Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


//For HR
Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/hr/dashboard', function() {
        return "This is HR Dashboard";
    })->name('hr.dashboard');
});

//For User/Employee
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', function() {
        return "This is normal User Dashboard";
    })->name('dashboard');
});

// 4. Admin এবং HR উভয়ের জন্য (মাল্টিপল রোল)
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/reports', function() {
        return "Company Reports (Accessible by Admin and HR)";
    })->name('reports');
});