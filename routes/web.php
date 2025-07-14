<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Divisi\Manager\MemoController;
use App\Http\Controllers\Divisi\Food\MemoController as FoodMemoController;
use App\Http\Controllers\Divisi\PengembanganController;
use App\Http\Controllers\Divisi\Manager\DashboardManagerController;
use App\Http\Controllers\Divisi\OpWil1Controller;
use App\Http\Controllers\Divisi\OpWil2Controller;
use App\Http\Controllers\Divisi\UmumLegalController;
use App\Http\Controllers\Divisi\AdminKeuController;
use App\Http\Controllers\Divisi\SipilController;
use App\Http\Controllers\Divisi\Food\DashboardFoodController;
use App\Http\Controllers\Divisi\MarketingController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('welcome2', function () {
    return view('welcome2');
});

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Routes (English)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Profil Routes (with Signature - Indonesian)
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfilController::class, 'update'])->name('update');
        Route::delete('/delete', [ProfilController::class, 'destroy'])->name('destroy');
        Route::get('/signature', [ProfilController::class, 'signatureIndex'])->name('signature.index');
        Route::get('/signature/create', [ProfilController::class, 'createSignature'])->name('signature.create');
        Route::post('/signature/upload', [ProfilController::class, 'uploadSignature'])->name('signature.upload');
        Route::post('/signature/save', [ProfilController::class, 'saveSignature'])->name('signature.save');
        Route::delete('/signature/delete', [ProfilController::class, 'deleteSignature'])->name('signature.delete');
    });

    // Admin Routes
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
        
        Route::resource('staff', StaffController::class)->names([
            'index' => 'staff.index',
            'create' => 'staff.create',
            'store' => 'staff.store',
            'edit' => 'staff.edit',
            'update' => 'staff.update',
            'destroy' => 'staff.destroy'
        ]);
    });

    // Division-Specific Routes
    $divisionRoutes = [
        'pengembangan' => [
            'middleware' => 'divisi:Pengembangan Bisnis',
            'controller' => PengembanganController::class
        ],
        'manager' => [
            'middleware' => 'divisi:Manager',
            'controller' => DashboardManagerController::class,
            'extra_routes' => [
                ['GET', '/memo', [MemoController::class, 'index'], 'memo.index'],
                ['GET', '/memo/{id}', [MemoController::class, 'show'], 'memo.show']
            ]
        ],
        'opwil1' => [
            'middleware' => 'divisi:Operasional Wilayah I',
            'controller' => OpWil1Controller::class
        ],
        'opwil2' => [
            'middleware' => 'divisi:Operasional Wilayah II',
            'controller' => OpWil2Controller::class
        ],
        'umumlegal' => [
            'middleware' => 'divisi:Umum dan Legal',
            'controller' => UmumLegalController::class
        ],
        'adminkeu' => [
            'middleware' => 'divisi:Administrasi dan Keuangan',
            'controller' => AdminKeuController::class
        ],
        'sipil' => [
            'middleware' => 'divisi:Infrastruktur dan Sipil',
            'controller' => SipilController::class
        ],
        'food' => [
            'middleware' => 'divisi:Food Beverage',
            'controller' => DashboardFoodController::class,
            'extra_routes' => [
                ['GET', '/memo', [FoodMemoController::class, 'index'], 'memo.index'],
                ['GET', '/memo/{id}', [FoodMemoController::class, 'show'], 'memo.show']
            ]
        ],
        'marketing' => [
            'middleware' => 'divisi:Marketing dan Sales',
            'controller' => MarketingController::class
        ]
    ];

    foreach ($divisionRoutes as $prefix => $config) {
        Route::prefix($prefix)
            ->middleware($config['middleware'])
            ->name($prefix.'.')
            ->group(function () use ($config) {
                Route::get('/dashboard', [$config['controller'], 'index'])->name('dashboard');
                
                if (isset($config['extra_routes'])) {
                    foreach ($config['extra_routes'] as $route) {
                        Route::{$route[0]}($route[1], $route[2])->name($route[3]);
                    }
                }
            });
    }

    // Main Dashboard Redirector
    Route::get('/dashboard', function () {
        $user = auth()->user();
    
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    
        $divisiRoutes = [
            'Pengembangan Bisnis' => 'pengembangan.dashboard',
            'Manager' => 'manager.dashboard',
            'Operasional Wilayah I' => 'opwil1.dashboard',
            'Operasional Wilayah II' => 'opwil2.dashboard',
            'Umum dan Legal' => 'umumlegal.dashboard',
            'Administrasi dan Keuangan' => 'adminkeu.dashboard',
            'Infrastruktur dan Sipil' => 'sipil.dashboard',
            'Food Beverage' => 'food.dashboard',
            'Marketing dan Sales' => 'marketing.dashboard',
        ];
    
        return redirect()->route(
            $divisiRoutes[$user->divisi->nama ?? ''] ?? 'login'
        );
    })->name('main.dashboard');
});