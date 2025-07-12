<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class CekDivisi
{
    public function handle($request, Closure $next, $divisi)
    {
        $user = auth()->user();

        // Jika belum login, abaikan pengecekan (hindari error 403 sebelum login)
        if (!$user) {
            return redirect()->route('login');
        }

        // Debug (sementara)
        // dd([
        //     'user' => $user->name,
        //     'user_divisi' => $user->divisi?->nama,
        //     'expected_divisi' => $divisi
        // ]);

        // Bandingkan dengan lebih fleksibel (case-insensitive)
        if ($user->divisi && Str::lower($user->divisi->nama) === Str::lower($divisi)) {
            return $next($request);
        }

        abort(403, 'AKSES DITOLAK.');
    }
}
