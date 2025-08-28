<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

class AsistenManagerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $userDivisi = $user->divisi->nama ?? 'Unknown';

        // Hitung statistik memo untuk divisi asisten manager yang sedang login
        $totalMemo = Memo::where('dari', $userDivisi)->count();
        
        $menungguPersetujuan = Memo::where('dari', $userDivisi)
            ->whereIn('status', ['diajukan', 'revisi'])
            ->count();
            
        $telahDisetujui = Memo::where('dari', $userDivisi)
            ->where('status', 'disetujui')
            ->count();

        // Ambil memo terbaru untuk aktivitas terbaru
        $recentMemos = Memo::where('dari', $userDivisi)
            ->with(['dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Hitung memo yang ditolak (opsional, untuk informasi tambahan)
        $ditolak = Memo::where('dari', $userDivisi)
            ->where('status', 'ditolak')
            ->count();

        return view('asmen.dashboard', compact(
            'user', 
            'userDivisi',
            'totalMemo',
            'menungguPersetujuan', 
            'telahDisetujui',
            'recentMemos',
            'ditolak'
        ));
    }
}