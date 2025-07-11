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

    $user = auth()->user();
    
    // Debug log
    \Log::info('Login Process', [
        'user_id' => $user->id,
        'role' => $user->role,
        'divisi' => $user->divisi_id
    ]);

    // 1. Prioritas untuk admin (tanpa perlu cek divisi)
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // 2. Cek untuk manager (jika ada divisi)
    if ($user->divisi && strtolower($user->divisi->nama) === 'manager') {
        return redirect()->route('manager.dashboard');
    }

    // 3. Default untuk staff
    return redirect()->intended('staff/dashboard');
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