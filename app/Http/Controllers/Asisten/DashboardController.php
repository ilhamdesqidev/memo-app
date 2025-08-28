<?php

namespace App\Http\Controllers\Asisten;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userDivisi = $user->divisi->nama ?? 'Unknown';

        // Hitung statistik memo untuk divisi asisten yang sedang login
        $pendingMemos = Memo::where('dari', $userDivisi)
            ->whereIn('status', ['diajukan', 'revisi'])
            ->count();
            
        $approvedMemos = Memo::where('dari', $userDivisi)
            ->where('status', 'disetujui')
            ->count();

        $rejectedMemos = Memo::where('dari', $userDivisi)
            ->where('status', 'ditolak')
            ->count();

        // Ambil aktivitas terbaru
        $recentMemos = Memo::where('dari', $userDivisi)
            ->with(['dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
            ->orderBy('updated_at', 'desc')
            ->limit(4)
            ->get();

        return view('asisten.dashboard', compact(
            'user', 
            'userDivisi',
            'pendingMemos',
            'approvedMemos', 
            'rejectedMemos',
            'recentMemos'
        ));
    }
}