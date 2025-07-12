<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekDivisi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $divisi)
    {
        if (auth()->check() && auth()->user()->divisi === $divisi) {
            return $next($request);
        }
    
        abort(403, 'Akses ditolak.');
    }
    
}
