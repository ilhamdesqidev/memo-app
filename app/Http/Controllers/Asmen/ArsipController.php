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
        
        // Ambil memo yang sudah selesai (disetujui/ditolak) hanya dari divisi yang sama
        $memos = Memo::whereIn('status', ['disetujui', 'ditolak'])
            ->where('dari', $userDivisi) // Hanya memo dari divisi asisten manager
            ->with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('asmen.arsip.index', compact('memos'));
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
}