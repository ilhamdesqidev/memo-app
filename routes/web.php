<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Manager\DashboardManagerController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Divisi\Food\DashboardFoodController;
use App\Http\Controllers\Divisi\marketing\DashboardMarketingController;
use App\Http\Controllers\Divisi\pengembangan\DashboardPengembanganController;
use App\Http\Controllers\Divisi\op1\DashboardOp1Controller;
use App\Http\Controllers\Divisi\op2\DashboardOp2Controller;
use App\Http\Controllers\Divisi\adminkeu\DashboardAdminkeuController;
use App\Http\Controllers\Divisi\umumlegal\DashboardUmumLegalController;
use App\Http\Controllers\Divisi\sipil\DashboardSipilController;
use App\Http\Controllers\Manager\ManagerMemoController;
use App\Http\Controllers\Divisi\marketing\MemoController as MarketingMemoController;
use App\Http\Controllers\Divisi\pengembangan\MemoController as PengembanganMemoController;
use App\Http\Controllers\Divisi\Food\MemoController as FoodMemoController;
use App\Http\Controllers\Divisi\op1\MemoController as Op1MemoController;
use App\Http\Controllers\Divisi\op2\MemoController as Op2MemoController;
use App\Http\Controllers\Divisi\adminkeu\MemoController as AdminKeuMemoController;
use App\Http\Controllers\Divisi\umumlegal\MemoController as UmumLegalMemoController;
use App\Http\Controllers\Divisi\sipil\MemoController as SipilMemoController;
use App\Http\Controllers\AsistenManagerController;
use App\Http\Controllers\Asmen\ArsipController;
use App\Http\Controllers\Asmen\MemoController;

/*-------------------------------------------------------------------------
| Public Routes
|-------------------------------------------------------------------------*/
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

/*-------------------------------------------------------------------------
| Authenticated Routes (All Roles)
|-------------------------------------------------------------------------*/
Route::middleware(['auth'])->group(function () {
    // Main Dashboard Redirector
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        switch ($user->role) {
            case 'manager':
                return redirect()->route('manager.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'asisten_manager':
                return redirect()->route('asmen.dashboard');
            default:
                $divisiRoutes = [
                    'Pengembangan Bisnis' => 'pengembangan.dashboard',
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
        }
    })->name('main.dashboard');
});

/*-------------------------------------------------------------------------
| Profile Routes (Separated by role)
|-------------------------------------------------------------------------*/

// ADMIN ONLY PROFILE ROUTES
Route::prefix('profile')->name('profile.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
});

// Single profile route group accessible to all authenticated users
Route::prefix('profil')->name('profil.')->middleware('auth')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('/edit', [ProfilController::class, 'edit'])->name('edit');
    Route::patch('/update', [ProfilController::class, 'update'])->name('update');
    Route::delete('/delete', [ProfilController::class, 'destroy'])->name('destroy');
    
    // Signature routes
    Route::get('/signature', [ProfilController::class, 'signatureIndex'])->name('signature.index');
    Route::get('/signature/create', [ProfilController::class, 'createSignature'])->name('signature.create');
    Route::post('/signature/upload', [ProfilController::class, 'uploadSignature'])->name('signature.upload');
    Route::post('/signature/save', [ProfilController::class, 'saveSignature'])->name('signature.save');
    Route::delete('/signature/delete', [ProfilController::class, 'deleteSignature'])->name('signature.delete');
});

/*-------------------------------------------------------------------------
| Admin Routes
|-------------------------------------------------------------------------*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
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

/*-------------------------------------------------------------------------
| Manager Routes
|-------------------------------------------------------------------------*/
Route::prefix('manager')->middleware(['auth', 'role:manager'])->name('manager.')->group(function () {
    Route::get('/dashboard', [DashboardManagerController::class, 'index'])->name('dashboard');
    
    // Memo routes
    Route::prefix('memo')->name('memo.')->group(function () {
        Route::get('/inbox', [ManagerMemoController::class, 'inbox'])->name('inbox');
        Route::get('/{memo}', [ManagerMemoController::class, 'show'])->name('show');
        Route::post('/{memo}/approve', [ManagerMemoController::class, 'approve'])->name('approve');
        Route::post('/{memo}/reject', [ManagerMemoController::class, 'reject'])->name('reject');
    });
});

/*-------------------------------------------------------------------------
| Asisten Manager Routes
|-------------------------------------------------------------------------*/
Route::prefix('asmen')->middleware(['auth', 'role:asisten_manager'])->name('asmen.')->group(function () {
    Route::get('/dashboard', [AsistenManagerController::class, 'dashboard'])->name('dashboard');
    
    // Memo routes
    Route::prefix('memo')->name('memo.')->group(function () {
        Route::get('/inbox', [MemoController::class, 'inbox'])->name('inbox');
        Route::get('/{memo}', [MemoController::class, 'show'])->name('show');
        Route::post('/{memo}/approve', [MemoController::class, 'approve'])->name('approve');
        Route::post('/{memo}/reject', [MemoController::class, 'reject'])->name('reject');
        Route::post('/{memo}/request-revision', [MemoController::class, 'requestRevision'])->name('request-revision');
    });
    
    // Arsip routes
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip');
});

/*-------------------------------------------------------------------------
| Divisi Routes
|-------------------------------------------------------------------------*/

// Divisi Pengembangan Bisnis
Route::prefix('pengembangan')
    ->middleware(['auth', 'divisi:Pengembangan Bisnis'])
    ->name('pengembangan.')
    ->group(function () {
        Route::get('/dashboard', [DashboardPengembanganController::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [PengembanganMemoController::class, 'index'])->name('index');
            Route::get('/inbox', [PengembanganMemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [PengembanganMemoController::class, 'create'])->name('create');
            Route::post('/', [PengembanganMemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [PengembanganMemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [PengembanganMemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [PengembanganMemoController::class, 'update'])->name('update');
            Route::post('/update-status', [PengembanganMemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [PengembanganMemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [PengembanganMemoController::class, 'viewPdf'])->name('pdf');
        });
    });

// Divisi Operasional Wilayah I
Route::prefix('opwil1')
    ->middleware(['auth', 'divisi:Operasional Wilayah I'])
    ->name('opwil1.')
    ->group(function () {
        Route::get('/dashboard', [DashboardOp1Controller::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [Op1MemoController::class, 'index'])->name('index');
            Route::get('/inbox', [Op1MemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [Op1MemoController::class, 'create'])->name('create');
            Route::post('/', [Op1MemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [Op1MemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [Op1MemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [Op1MemoController::class, 'update'])->name('update');
            Route::post('/update-status', [Op1MemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [Op1MemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [Op1MemoController::class, 'viewPdf'])->name('pdf');
        });
    });

// Divisi Operasional Wilayah II
Route::prefix('opwil2')
    ->middleware(['auth', 'divisi:Operasional Wilayah II'])
    ->name('opwil2.')
    ->group(function () {
        Route::get('/dashboard', [DashboardOp2Controller::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [Op2MemoController::class, 'index'])->name('index');
            Route::get('/inbox', [Op2MemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [Op2MemoController::class, 'create'])->name('create');
            Route::post('/', [Op2MemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [Op2MemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [Op2MemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [Op2MemoController::class, 'update'])->name('update');
            Route::post('/update-status', [Op2MemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [Op2MemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [Op2MemoController::class, 'viewPdf'])->name('pdf');
        });
    });

// Divisi Umum dan Legal
Route::prefix('umumlegal')
    ->middleware(['auth', 'divisi:Umum dan Legal'])
    ->name('umumlegal.')
    ->group(function () {
        Route::get('/dashboard', [DashboardUmumLegalController::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [UmumLegalMemoController::class, 'index'])->name('index');
            Route::get('/inbox', [UmumLegalMemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [UmumLegalMemoController::class, 'create'])->name('create');
            Route::post('/', [UmumLegalMemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [UmumLegalMemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [UmumLegalMemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [UmumLegalMemoController::class, 'update'])->name('update');
            Route::post('/update-status', [UmumLegalMemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [UmumLegalMemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [UmumLegalMemoController::class, 'viewPdf'])->name('pdf');
        });
    });

// Divisi Administrasi dan Keuangan
Route::prefix('adminkeu')
    ->middleware(['auth', 'divisi:Administrasi dan Keuangan'])
    ->name('adminkeu.')
    ->group(function () {
        Route::get('/dashboard', [DashboardAdminkeuController::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [AdminKeuMemoController::class, 'index'])->name('index');
            Route::get('/inbox', [AdminKeuMemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [AdminKeuMemoController::class, 'create'])->name('create');
            Route::post('/', [AdminKeuMemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [AdminKeuMemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [AdminKeuMemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [AdminKeuMemoController::class, 'update'])->name('update');
            Route::post('/update-status', [AdminKeuMemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [AdminKeuMemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [AdminKeuMemoController::class, 'viewPdf'])->name('pdf');
        });
    });

// Divisi Infrastruktur dan Sipil
Route::prefix('sipil')
    ->middleware(['auth', 'divisi:Infrastruktur dan Sipil'])
    ->name('sipil.')
    ->group(function () {
        Route::get('/dashboard', [DashboardSipilController::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [SipilMemoController::class, 'index'])->name('index');
            Route::get('/inbox', [SipilMemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [SipilMemoController::class, 'create'])->name('create');
            Route::post('/', [SipilMemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [SipilMemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [SipilMemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [SipilMemoController::class, 'update'])->name('update');
            Route::post('/update-status', [SipilMemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [SipilMemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [SipilMemoController::class, 'viewPdf'])->name('pdf');
        });
    });

// Divisi Food Beverage
Route::prefix('food')
    ->middleware(['auth', 'divisi:Food Beverage'])
    ->name('food.')
    ->group(function () {
        Route::get('/dashboard', [DashboardFoodController::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [FoodMemoController::class, 'index'])->name('index');
            Route::get('/inbox', [FoodMemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [FoodMemoController::class, 'create'])->name('create');
            Route::post('/', [FoodMemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [FoodMemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [FoodMemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [FoodMemoController::class, 'update'])->name('update');
            Route::post('/update-status', [FoodMemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [FoodMemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [FoodMemoController::class, 'viewPdf'])->name('pdf');
        });
    });

// Divisi Marketing dan Sales
Route::prefix('marketing')
    ->middleware(['auth', 'divisi:Marketing dan Sales'])
    ->name('marketing.')
    ->group(function () {
        Route::get('/dashboard', [DashboardMarketingController::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [MarketingMemoController::class, 'index'])->name('index');
            Route::get('/inbox', [MarketingMemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [MarketingMemoController::class, 'create'])->name('create');
            Route::post('/', [MarketingMemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [MarketingMemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [MarketingMemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [MarketingMemoController::class, 'update'])->name('update');
            Route::post('/update-status', [MarketingMemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [MarketingMemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [MarketingMemoController::class, 'viewPdf'])->name('pdf');
        });
    });

/*-------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------*/
Route::get('/api/search-asisten-manager', function (Illuminate\Http\Request $request) {
    $query = $request->input('q');
    
    $users = App\Models\User::where(function($q) use ($query) {
            $q->where('name', 'like', "%$query%")
              ->orWhere('username', 'like', "%$query%");
        })
        ->where('role', 'asisten_manager')
        ->with('divisi')
        ->limit(10)
        ->get()
        ->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'jabatan' => $user->jabatan ?? '-',
                'divisi_nama' => $user->divisi->nama ?? '-',
                'divisi_id' => $user->divisi->id ?? null,
                'role' => $user->role
            ];
        });

    return response()->json($users);
})->middleware('auth')->name('api.search-asisten-manager');