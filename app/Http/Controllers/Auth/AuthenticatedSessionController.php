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

    if ($user->role === 'user') {
        switch ($user->divisi) {
            case 'Pengembangan Bisnis':
                return redirect()->route('pengembangan.dashboard');
            case 'Manager':
                return redirect()->route('manager.dashboard');
            case 'Operasional Wilayah I':
                return redirect()->route('opwil1.dashboard');
            case 'Operasional Wilayah II':
                return redirect()->route('opwil2.dashboard');
            case 'Umum dan Legal':
                return redirect()->route('umumlegal.dashboard');
            case 'Administrasi dan Keuangan':
                return redirect()->route('adminkeu.dashboard');
            case 'Infrastruktur dan Sipil':
                return redirect()->route('sipil.dashboard');
            case 'Food Beverage':
                return redirect()->route('food.dashboard');
            case 'Marketing dan Sales':
                return redirect()->route('marketing.dashboard');
            default:
                abort(403);
        }
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