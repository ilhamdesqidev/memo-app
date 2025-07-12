<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class CekDivisi
{
    public function handle($request, Closure $next, $divisi)
    {
        $user = auth()->user();

        // Cek login
        if (!$user) {
            return redirect()->route('login');
        }

        // Jika divisi adalah relasi, bandingkan berdasarkan nama
        $userDivisiNama = optional($user->divisi)->nama;

        if (Str::lower($userDivisiNama) === Str::lower($divisi)) {
            return $next($request);
        }

        abort(403, 'AKSES DITOLAK.');
    }
}