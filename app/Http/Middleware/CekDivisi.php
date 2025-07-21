<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class CekDivisi
{
    public function handle($request, Closure $next, ...$divisions)
    {
        $user = auth()->user();

        // Cek login
        if (!$user) {
            return redirect()->route('login');
        }

        // Admin bisa melewati pengecekan divisi
        if ($user->role === 'admin') {
            return $next($request);
        }

        $userDivisiNama = optional($user->divisi)->nama;

        // Cek semua divisi yang diizinkan
        foreach ($divisions as $divisi) {
            if (Str::lower($userDivisiNama) === Str::lower($divisi)) {
                return $next($request);
            }
        }

        abort(403, 'AKSES DITOLAK: Anda tidak memiliki hak akses ke divisi ini.');
    }
}