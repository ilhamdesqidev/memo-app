<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDivisi
{
    public function handle($request, Closure $next, $divisi)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $userDivisi = optional(auth()->user()->divisi)->nama;

    if (strtolower($userDivisi) !== strtolower($divisi)) {
        return redirect()->route('staff.dashboard')
               ->with('error', 'Unauthorized access');
    }

    return $next($request);
}
}