<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\MemoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome2', function () {
    return view('welcome2');
});

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

// Staff Dashboard
Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->middleware(['auth', 'verified'])->name('staff.dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
        
        // Staff Management
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });

    // Memo Routes
    Route::get('/staff/memo', [MemoController::class, 'index'])->name('staff.memo');
});

// Default dashboard route (bisa dihapus jika tidak digunakan)
Route::get('/dashboard', function () {
    return redirect()->route('staff.dashboard');
})->middleware(['auth'])->name('dashboard');