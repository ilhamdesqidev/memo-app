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
use App\Http\Controllers\Asisten\DashboardController as AsistenDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Asisten\AsistenMemoController;


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
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'manager':
                return redirect()->route('manager.dashboard');
            case 'asisten_manager':
                return redirect()->route('asmen.dashboard');
            case 'asisten':
                return redirect()->route('asisten.dashboard');
            case 'staff':
                $divisiRoutes = [
                    'Pengembangan Bisnis' => 'staff.dashboard',
                    'Operasional Wilayah I' => 'staff.dashboard',
                    'Operasional Wilayah II' => 'staff.dashboard',
                    'Umum dan Legal' => 'staff.dashboard',
                    'Administrasi dan Keuangan' => 'staff.dashboard',
                    'Infrastruktur dan Sipil' => 'staff.dashboard',
                    'Food Beverage' => 'staff.dashboard',
                    'Marketing dan Sales' => 'staff.dashboard',
                ];
                return redirect()->route($divisiRoutes[$user->divisi->nama ?? ''] ?? 'login');
            default:
                return redirect()->route('login');
        }
    })->name('main.dashboard');
});

/*-------------------------------------------------------------------------
| Profile Routes
|-------------------------------------------------------------------------*/

// Admin Profile Routes
Route::prefix('profile')->name('profile.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
});

// General Profile Routes (accessible to all authenticated users)
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
    Route::get('/staff/check-quotas', [StaffController::class, 'checkQuotas'])->name('staff.check-quotas');
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
| Asisten Routes
|-------------------------------------------------------------------------*/
Route::prefix('asisten')->middleware(['auth', 'role:asisten'])->name('asisten.')->group(function () {
    Route::get('/dashboard', [AsistenDashboardController::class, 'index'])->name('dashboard');
     // Halaman utama (index)
    Route::get('/index', [AsistenMemoController::class, 'index'])->name('index');
    // Halaman detail show
    Route::get('/show/{id}', [AsistenMemoController::class, 'show'])->name('show');
});

/*-------------------------------------------------------------------------
| Staff Routes (Previously User)
|-------------------------------------------------------------------------*/
Route::prefix('staff')
    ->middleware(['auth', 'role:staff'])
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
        
        Route::prefix('memo')->name('memo.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Staff\MemoController::class, 'index'])->name('index');
            Route::get('/inbox', [\App\Http\Controllers\Staff\MemoController::class, 'inbox'])->name('inbox');
            Route::get('/create', [\App\Http\Controllers\Staff\MemoController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Staff\MemoController::class, 'store'])->name('store');
            Route::get('/{memo}', [\App\Http\Controllers\Staff\MemoController::class, 'show'])->name('show');
            Route::get('/{memo}/edit', [\App\Http\Controllers\Staff\MemoController::class, 'edit'])->name('edit');
            Route::put('/{memo}', [\App\Http\Controllers\Staff\MemoController::class, 'update'])->name('update');
            Route::post('/update-status', [\App\Http\Controllers\Staff\MemoController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{memo}/regenerate-pdf', [\App\Http\Controllers\Staff\MemoController::class, 'regeneratePdf'])->name('regenerate-pdf');
            Route::get('/{memo}/pdf', [\App\Http\Controllers\Staff\MemoController::class, 'viewPdf'])
            ->name('pdf');
        });
    });


/*-------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------*/
Route::get('/api/search-asisten-manager', function (Illuminate\Http\Request $request) {
    $query = $request->input('q');
    $currentDivisi = $request->input('current_divisi');
    
    $users = App\Models\User::where(function($q) use ($query) {
            $q->where('name', 'like', "%$query%")
              ->orWhere('username', 'like', "%$query%");
        })
        ->where('role', 'asisten_manager')
        ->whereHas('divisi', function($q) use ($currentDivisi) {
            $q->where('nama', '=', $currentDivisi);
        })
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