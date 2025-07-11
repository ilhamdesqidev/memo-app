<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   // app/Http/Middleware/IsAdmin.php
public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Cek role admin saja, abaikan divisi
    if (Auth::user()->role === 'admin') {
        return $next($request);
    }

    return redirect()->route('staff.dashboard')
           ->with('error', 'Akses admin diperlukan');
}
}
