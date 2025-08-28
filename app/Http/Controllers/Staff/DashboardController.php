<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Memo;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $divisi = $user->divisi->nama;
        
        // Hitung memo keluar (semua memo yang dibuat oleh user)
        $memoKeluar = Memo::where('dibuat_oleh_user_id', $user->id)
                        ->count();
        
        // Hitung memo masuk (memo yang ditujukan ke divisi user dan bukan dari divisi user)
        $memoMasuk = Memo::where('divisi_tujuan', $divisi)
                        ->where('dari', '!=', $divisi)
                        ->whereIn('status', ['diajukan', 'revisi'])
                        ->count();
        
        // Hitung memo disetujui
        $memoDisetujui = Memo::where('dibuat_oleh_user_id', $user->id)
                            ->where('status', 'disetujui')
                            ->count();
        
        // Hitung memo ditolak
        $memoDitolak = Memo::where('dibuat_oleh_user_id', $user->id)
                          ->where('status', 'ditolak')
                          ->count();
        
        // Hitung memo pending (memo yang masih diajukan atau revisi)
        $memoPending = Memo::where('dibuat_oleh_user_id', $user->id)
                          ->whereIn('status', ['diajukan', 'revisi'])
                          ->count();
        
        // Ambil 5 memo terbaru
        $memoTerbaru = Memo::where(function($query) use ($user, $divisi) {
                            $query->where('dibuat_oleh_user_id', $user->id)
                                  ->orWhere('divisi_tujuan', $divisi);
                        })
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
        
        return view('staff.dashboard', [
            'divisi' => $divisi,
            'memoKeluar' => $memoKeluar,
            'memoMasuk' => $memoMasuk,
            'memoDisetujui' => $memoDisetujui,
            'memoDitolak' => $memoDitolak,
            'memoPending' => $memoPending,
            'memoTerbaru' => $memoTerbaru,
            // Tambahkan variabel untuk kompatibilitas dengan view
            'pendingMemos' => $memoPending,
            'approvedMemos' => $memoDisetujui,
            'rejectedMemos' => $memoDitolak
        ]);
    }
}