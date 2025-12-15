<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\MemoLog;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // PERBAIKAN: Ambil aktivitas terbaru dengan handling null user
        $recentActivities = MemoLog::with(['user' => function($query) {
                // Gunakan withTrashed jika ada soft delete
                $query->withTrashed();
            }])
            ->whereNotNull('divisi') // Hanya ambil log yang punya divisi
            ->orderBy('waktu', 'desc')
            ->limit(5)
            ->get();

        // Tambahkan statistik divisi jika diperlukan
        $activeDivisions = Divisi::withCount(['memos' => function($query) {
                $query->where('status', '!=', 'ditolak');
            }])
            ->orderBy('memos_count', 'desc')
            ->limit(3)
            ->get();

        return view('manager.dashboard', compact(
            'totalMemo', 
            'pendingMemo', 
            'approvedMemo',
            'rejectedMemo',
            'recentActivities',
            'activeDivisions'
        ));
    }
}