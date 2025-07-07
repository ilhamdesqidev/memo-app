<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;   
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

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

// User Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - menggunakan middleware sederhana dulu
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        // Admin Users Management
        Route::resource('users', UserController::class);
    });
});