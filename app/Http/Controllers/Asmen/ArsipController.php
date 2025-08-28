<?php

namespace App\Http\Controllers\Asmen;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // Ambil divisi asisten manager yang sedang login
        $userDivisi = Auth::user()->divisi->nama;
        
        $query = Memo::whereIn('status', ['disetujui', 'ditolak'])
            ->where('dari', $userDivisi) // Hanya memo dari divisi asisten manager
            ->with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh']);

        // Filter berdasarkan status jika ada
        if ($request->has('status') && in_array($request->status, ['disetujui', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan periode tanggal jika ada
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan pencarian perihal
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('perihal', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor', 'like', '%' . $request->search . '%')
                  ->orWhere('kepada', 'like', '%' . $request->search . '%');
            });
        }

        $memos = $query->orderBy('updated_at', 'desc')
                      ->paginate(15)
                      ->withQueryString();

        // Hitung statistik untuk arsip
        $totalArsip = Memo::whereIn('status', ['disetujui', 'ditolak'])
                         ->where('dari', $userDivisi)
                         ->count();
                         
        $disetujui = Memo::where('status', 'disetujui')
                        ->where('dari', $userDivisi)
                        ->count();
                        
        $ditolak = Memo::where('status', 'ditolak')
                      ->where('dari', $userDivisi)
                      ->count();

        return view('asmen.arsip.index', compact(
            'memos', 
            'totalArsip', 
            'disetujui', 
            'ditolak',
            'userDivisi'
        ));
    }

    public function viewPdf($id)
    {
        $memo = Memo::with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
                   ->findOrFail($id);
        
        // Pastikan hanya memo dari divisi asisten manager yang bisa diakses
        if ($memo->dari !== Auth::user()->divisi->nama) {
            abort(403, 'Unauthorized access.');
        }
        
        // Pastikan hanya memo yang disetujui yang bisa dilihat
        if ($memo->status !== 'disetujui') {
            abort(403, 'Hanya memo yang disetujui yang dapat dilihat sebagai PDF.');
        }
        
        $pdf = PDF::loadView('memo.pdf', compact('memo'));
        
        // Format nama file yang aman
        $fileName = $this->generateSafeFileName($memo);
        
        return $pdf->stream($fileName);
    }

    /**
     * Mengunduh PDF
     */
    public function generatePDF($id)
    {
        $memo = Memo::with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
                   ->findOrFail($id);
        
        // Pastikan hanya memo dari divisi asisten manager yang bisa diakses
        if ($memo->dari !== Auth::user()->divisi->nama) {
            abort(403, 'Unauthorized access.');
        }
        
        // Pastikan hanya memo yang disetujui yang bisa di-download
        if ($memo->status !== 'disetujui') {
            abort(403, 'Hanya memo yang disetujui yang dapat diunduh sebagai PDF.');
        }
        
        $pdf = PDF::loadView('memo.pdf', compact('memo'));
        
        // Format nama file yang aman
        $fileName = $this->generateSafeFileName($memo);
        
        return $pdf->download($fileName);
    }

    /**
     * Generate nama file yang aman untuk PDF
     */
    private function generateSafeFileName($memo)
    {
        // Ambil tanggal dari created_at
        $date = Carbon::parse($memo->created_at)->format('Y-m-d');
        
        // Bersihkan nomor memo dari karakter khusus
        $cleanNumber = preg_replace('/[\/\\\\:*?"<>|]/', '-', $memo->nomor);
        
        // Gabungkan semua informasi
        $fileName = "Memo_{$cleanNumber}_{$date}.pdf";
        
        // Hapus multiple dash dan trim
        $fileName = preg_replace('/-+/', '-', $fileName);
        $fileName = trim($fileName, '-');
        
        return $fileName;
    }

    public function show($id)
    {
        $memo = Memo::with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh', 'logs'])
                   ->findOrFail($id);
        
        // Pastikan hanya memo dari divisi asisten manager yang bisa diakses
        if ($memo->dari !== Auth::user()->divisi->nama) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE MEMO INI.');
        }
        
        return view('asmen.arsip.show', compact('memo'));
    }

    
}