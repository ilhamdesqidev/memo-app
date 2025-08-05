<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Periksa apakah pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Dapatkan user yang sedang login
        $user = auth()->user();

        // Periksa role pengguna
        if ($user->role !== $role) {
            // Jika role tidak sesuai, redirect ke halaman yang sesuai atau beri error
            return abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}