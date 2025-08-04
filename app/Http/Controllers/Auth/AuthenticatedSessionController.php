<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   // app/Http/Controllers/Auth/AuthenticatedSessionController.php
// app/Http/Controllers/Auth/AuthenticatedSessionController.php
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->role === 'manager') {
        return redirect()->route('manager.dashboard');
    }

    if ($user->role === 'asisten_manager') {
        return redirect()->route('asmen.dashboard');
    }    
    
    if ($user->role === 'user') {
        // pastikan relasi divisi termuat
        $divisi = $user->divisi->nama ?? null;
    
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
    
        return redirect()->route($divisiRoutes[$divisi] ?? 'login');
    }
    
    abort(403);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}