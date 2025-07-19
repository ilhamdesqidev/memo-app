<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Divisi\Manager\MemoController;
use App\Http\Controllers\Divisi\Manager\DashboardManagerController;
use App\Http\Controllers\Divisi\Food\DashboardFoodController;
use App\Http\Controllers\Divisi\marketing\DashboardMarketingController;
use App\Http\Controllers\Divisi\pengembangan\DashboardPengembanganController;
use App\Http\Controllers\Divisi\op1\DashboardOp1Controller;
use App\Http\Controllers\Divisi\op2\DashboardOp2Controller;
use App\Http\Controllers\Divisi\adminkeu\DashboardAdminkeuController;
use App\Http\Controllers\Divisi\umumlegal\DashboardUmumLegalController;
use App\Http\Controllers\Divisi\sipil\DashboardSipilController;
use App\Http\Controllers\Divisi\marketing\MemoController as MarketingMemoController;
use App\Http\Controllers\Divisi\pengembangan\MemoController as PengembanganMemoController;
use App\Http\Controllers\Divisi\Food\MemoController as FoodMemoController;
use App\Http\Controllers\Divisi\op1\MemoController as Op1MemoController;
use App\Http\Controllers\Divisi\op2\MemoController as Op2MemoController;
use App\Http\Controllers\Divisi\adminkeu\MemoController as AdminKeuMemoController;
use App\Http\Controllers\Divisi\umumlegal\MemoController as UmumLegalMemoController;
use App\Http\Controllers\Divisi\sipil\MemoController as SipilMemoController;


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
Route::prefix('pengembangan')
    ->middleware('divisi:Pengembangan Bisnis')
    ->name('pengembangan.')
    ->group(function () {
        Route::get('/dashboard', [DashboardPengembanganController::class, 'index'])->name('dashboard');
        Route::get('/memo', [PengembanganMemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/{id}', [PengembanganMemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('manager')
    ->middleware('divisi:Manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', [DashboardManagerController::class, 'index'])->name('dashboard');
        Route::get('/memo', [MemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/create', [MemoController::class, 'create'])->name('memo.create'); // Add this line
        Route::get('/memo/{id}', [MemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('opwil1')
    ->middleware('divisi:Operasional Wilayah I')
    ->name('opwil1.')
    ->group(function () {
        Route::get('/dashboard', [DashboardOp1Controller::class, 'index'])->name('dashboard');
        Route::get('/memo', [Op1MemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/{id}', [Op1MemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('opwil2')
    ->middleware('divisi:Operasional Wilayah II')
    ->name('opwil2.')
    ->group(function () {
        Route::get('/dashboard', [DashboardOp2Controller::class, 'index'])->name('dashboard');
        Route::get('/memo', [Op2MemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/{id}', [Op2MemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('umumlegal')
    ->middleware('divisi:Umum dan Legal')
    ->name('umumlegal.')
    ->group(function () {
        Route::get('/dashboard', [DashboardUmumLegalController::class, 'index'])->name('dashboard');
        Route::get('/memo', [UmumLegalMemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/{id}', [UmumLegalMemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('adminkeu')
    ->middleware('divisi:Administrasi dan Keuangan')
    ->name('adminkeu.')
    ->group(function () {
        Route::get('/dashboard', [DashboardAdminkeuController::class, 'index'])->name('dashboard');
        Route::get('/memo', [AdminKeuMemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/{id}', [AdminKeuMemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('sipil')
    ->middleware('divisi:Infrastruktur dan Sipil')
    ->name('sipil.')
    ->group(function () {
        Route::get('/dashboard', [DashboardSipilController::class, 'index'])->name('dashboard');
        Route::get('/memo', [SipilMemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/{id}', [SipilMemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('food')
    ->middleware('divisi:Food Beverage')
    ->name('food.')
    ->group(function () {
        Route::get('/dashboard', [DashboardFoodController::class, 'index'])->name('dashboard');
        Route::get('/memo', [FoodMemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/{id}', [FoodMemoController::class, 'show'])->name('memo.show');
    });

Route::prefix('marketing')
    ->middleware('divisi:Marketing dan Sales')
    ->name('marketing.')
    ->group(function () {
        Route::get('/dashboard', [DashboardMarketingController::class, 'index'])->name('dashboard');

        Route::get('/memo', [MarketingMemoController::class, 'index'])->name('memo.index');
        Route::get('/memo/create', [MarketingMemoController::class, 'create'])->name('memo.create'); // <-- Ini penting
        Route::post('/memo', [MarketingMemoController::class, 'store'])->name('memo.store');
        Route::get('/memo/{id}', [MarketingMemoController::class, 'show'])->name('memo.show');
    });


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