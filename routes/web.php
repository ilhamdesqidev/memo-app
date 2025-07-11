<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\MemoController as ManagerMemoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome2', function () {
    return view('welcome2');
});

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Routes (accessible to all authenticated users)
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Profil Routes (I'm keeping both for compatibility)
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('profil.index');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::patch('/update', [ProfilController::class, 'update'])->name('profil.update');
        Route::delete('/delete', [ProfilController::class, 'destroy'])->name('profil.destroy');

        // Signature Routes
        Route::get('/signature', [ProfilController::class, 'signatureIndex'])->name('profil.signature.index');
        Route::get('/signature/create', [ProfilController::class, 'createSignature'])->name('profil.signature.create');
        Route::post('/signature/upload', [ProfilController::class, 'uploadSignature'])->name('profil.signature.upload');
        Route::post('/signature/save', [ProfilController::class, 'saveSignature'])->name('profil.signature.save');
        Route::delete('/signature/delete', [ProfilController::class, 'deleteSignature'])->name('profil.signature.delete');
    });

    // Admin Routes (role-based)
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
        
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });

    // Manager Routes (divisi-based)
    Route::prefix('manager')->middleware(['divisi:Manager'])->name('manager.')->group(function() {
        Route::get('dashboard', [\App\Http\Controllers\Manager\DashboardController::class, 'index'])
             ->name('dashboard');
            
        Route::get('memo', [ManagerMemoController::class, 'index'])->name('memo.index');
        Route::get('memo/{id}', [ManagerMemoController::class, 'show'])->name('memo.show');
        Route::post('memo/{id}/approve', [ManagerMemoController::class, 'approve'])->name('memo.approve');
        Route::put('memo/{id}/reject', [ManagerMemoController::class, 'reject'])->name('memo.reject');
    });

    // Staff Routes (default for authenticated users)
    Route::prefix('staff')->name('staff.')->group(function() {
        Route::get('dashboard', function () {
            return view('staff.dashboard');
        })->name('dashboard');

        Route::resource('memo', MemoController::class)->names([
            'index' => 'memo.index',
            'create' => 'memo.create',
            'store' => 'memo.store',
            'show' => 'memo.show',
            'edit' => 'memo.edit',
            'update' => 'memo.update',
            'destroy' => 'memo.destroy'
        ]);
    });

    // Default dashboard fallback
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($user->divisi && $user->divisi->nama === 'Manager') {
            return redirect()->route('manager.dashboard');
        }
        
        return redirect()->route('staff.dashboard');
    })->name('dashboard');
});
