<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\MemoLog;
use App\Models\Divisi;
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
        
        // Ambil aktivitas terbaru - dengan handling null user
        $recentActivities = MemoLog::with(['user' => function($query) {
                $query->withTrashed();
            }])
            ->whereNotNull('divisi')
            ->orderBy('waktu', 'desc')
            ->limit(5)
            ->get();

        // PERBAIKAN: Ambil divisi aktif menggunakan accessor
        $activeDivisions = Divisi::all()->map(function($divisi) {
            // Tambahkan count menggunakan accessor
            return (object) [
                'id' => $divisi->id,
                'nama' => $divisi->nama,
                'memo_count' => $divisi->memo_count,
                'approved_count' => $divisi->approved_count,
                'rejected_count' => $divisi->rejected_count,
                'pending_count' => $divisi->pending_count
            ];
        })->sortByDesc('memo_count')->take(3);

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