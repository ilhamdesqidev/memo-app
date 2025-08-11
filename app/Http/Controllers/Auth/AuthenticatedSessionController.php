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

        return $this->authenticated($request, Auth::user());
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'manager') {
            return redirect()->route('manager.dashboard');
        } elseif ($user->role === 'asisten_manager') {
            return redirect()->route('asmen.dashboard');
        } elseif ($user->role === 'asisten') {
            return redirect()->route('asisten.dashboard');
        } elseif ($user->role === 'staff') {
            $divisi = $user->divisi->nama ?? null;
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
            return redirect()->route($divisiRoutes[$divisi] ?? 'login');
        }
        abort(403, 'Unauthorized access.');
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