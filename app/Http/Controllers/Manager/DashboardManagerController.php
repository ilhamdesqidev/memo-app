<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;

class DashboardManagerController extends Controller
{
   public function index()
    {
        $user = auth()->user();
        
        // Hitung total semua memo dalam sistem
        $totalMemo = Memo::count();
        
        // Hitung memo yang menunggu persetujuan Manager (status diajukan dan divisi_tujuan = Manager)
        $pendingMemo = Memo::where('divisi_tujuan', 'Manager')
            ->where('status', 'diajukan')
            ->count();
        
        // Hitung semua memo yang telah disetujui (status disetujui)
        $approvedMemo = Memo::where('status', 'disetujui')->count();
            
        // Hitung semua memo yang ditolak (status ditolak)
        $rejectedMemo = Memo::where('status', 'ditolak')->count();
        
        // Ambil aktivitas terbaru (log memo)
        $recentActivities = \App\Models\MemoLog::with(['user', 'memo'])
            ->orderBy('waktu', 'desc')
            ->limit(5)
            ->get();

        return view('manager.dashboard', compact(
            'totalMemo', 
            'pendingMemo', 
            'approvedMemo',
            'rejectedMemo',
            'recentActivities'
        ));
    }
}