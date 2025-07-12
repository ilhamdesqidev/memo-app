<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\MemoController;

// Controller per divisi (user)
use App\Http\Controllers\Divisi\PengembanganController;
use App\Http\Controllers\Divisi\ManagerController;
use App\Http\Controllers\Divisi\OpWil1Controller;
use App\Http\Controllers\Divisi\OpWil2Controller;
use App\Http\Controllers\Divisi\UmumLegalController;
use App\Http\Controllers\Divisi\AdminKeuController;
use App\Http\Controllers\Divisi\SipilController;
use App\Http\Controllers\Divisi\FoodController;
use App\Http\Controllers\Divisi\MarketingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('welcome2', function () {
    return view('welcome2');
});

// Auth Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {

    // === Profile ===
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // === Profil (with Signature) ===
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('profil.index');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::patch('/update', [ProfilController::class, 'update'])->name('profil.update');
        Route::delete('/delete', [ProfilController::class, 'destroy'])->name('profil.destroy');
        Route::get('/signature', [ProfilController::class, 'signatureIndex'])->name('profil.signature.index');
        Route::get('/signature/create', [ProfilController::class, 'createSignature'])->name('profil.signature.create');
        Route::post('/signature/upload', [ProfilController::class, 'uploadSignature'])->name('profil.signature.upload');
        Route::post('/signature/save', [ProfilController::class, 'saveSignature'])->name('profil.signature.save');
        Route::delete('/signature/delete', [ProfilController::class, 'deleteSignature'])->name('profil.signature.delete');
    });

    // === Admin ===
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

    // === Divisi User ===
    Route::prefix('pengembangan')->middleware('divisi:Pengembangan Bisnis')->name('pengembangan.')->group(function () {
        Route::get('/dashboard', [PengembanganController::class, 'index'])->name('dashboard');
    });

    Route::prefix('manager')->middleware('divisi:Manager')->name('manager.')->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard');
    });

    Route::prefix('opwil1')->middleware('divisi:Operasional Wilayah I')->name('opwil1.')->group(function () {
        Route::get('/dashboard', [OpWil1Controller::class, 'index'])->name('dashboard');
    });

    Route::prefix('opwil2')->middleware('divisi:Operasional Wilayah II')->name('opwil2.')->group(function () {
        Route::get('/dashboard', [OpWil2Controller::class, 'index'])->name('dashboard');
    });

    Route::prefix('umumlegal')->middleware('divisi:Umum dan Legal')->name('umumlegal.')->group(function () {
        Route::get('/dashboard', [UmumLegalController::class, 'index'])->name('dashboard');
    });

    Route::prefix('adminkeu')->middleware('divisi:Administrasi dan Keuangan')->name('adminkeu.')->group(function () {
        Route::get('/dashboard', [AdminKeuController::class, 'index'])->name('dashboard');
    });

    Route::prefix('sipil')->middleware('divisi:Infrastruktur dan Sipil')->name('sipil.')->group(function () {
        Route::get('/dashboard', [SipilController::class, 'index'])->name('dashboard');
    });

    Route::prefix('food')->middleware('divisi:Food Beverage')->name('food.')->group(function () {
        Route::get('/dashboard', [FoodController::class, 'index'])->name('dashboard');
    });

    Route::prefix('marketing')->middleware('divisi:Marketing dan Sales')->name('marketing.')->group(function () {
        Route::get('/dashboard', [MarketingController::class, 'index'])->name('dashboard');
    });

    // === Fallback Redirect Dashboard ===
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

        return redirect()->route($divisiRoutes[$user->divisi] ?? 'login');
    })->name('dashboard');
});

Route::prefix('staff')->middleware('divisi:STAFF_DIVISI_JIKA_ADA')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
});