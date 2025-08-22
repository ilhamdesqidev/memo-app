<?php

namespace App\Http\Controllers\Asisten;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // Ambil divisi asisten yang sedang login
        $userDivisi = Auth::user()->divisi->nama;
        
        // Query untuk memo yang sudah selesai (disetujui/ditolak) hanya dari divisi yang sama
        $query = Memo::whereIn('status', ['disetujui', 'ditolak'])
            ->where('dari', $userDivisi) // Hanya memo dari divisi asisten
            ->with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status jika ada parameter
        if ($request->has('status') && in_array($request->status, ['disetujui', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $memos = $query->paginate(10);

        return view('asisten.arsip.index', compact('memos'));
    }

    public function show($id)
    {
        // Ambil memo berdasarkan ID
        $memo = Memo::with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
                    ->findOrFail($id);
        
        // Pastikan memo hanya bisa diakses oleh divisi yang sama
        $userDivisi = Auth::user()->divisi->nama;
        if ($memo->dari !== $userDivisi) {
            abort(403, 'UNAUTHORIZED ACCESS');
        }
        
        // Pastikan hanya memo yang sudah selesai (disetujui/ditolak) yang bisa dilihat di arsip
        if (!in_array($memo->status, ['disetujui', 'ditolak'])) {
            abort(403, 'Hanya memo yang sudah selesai yang dapat dilihat di arsip');
        }
        
        return view('asisten.arsip.show', compact('memo'));
    }

    public function generatePdf($id)
    {
        // Ambil memo berdasarkan ID
        $memo = Memo::with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
                    ->findOrFail($id);

        // Pastikan memo hanya bisa diakses oleh divisi yang sama
        $userDivisi = Auth::user()->divisi->nama;
        if ($memo->dari !== $userDivisi) {
            abort(403, 'UNAUTHORIZED ACCESS');
        }

        // Pastikan hanya memo yang disetujui yang bisa dilihat sebagai PDF
        if ($memo->status !== 'disetujui') {
            abort(403, 'Hanya memo yang disetujui yang dapat dilihat sebagai PDF');
        }

        // Load view PDF
        $pdf = PDF::loadView('memo.pdf', compact('memo'));

        // Sanitasi nama file biar tidak ada "/" atau "\"
        $safeNomor = str_replace(['/', '\\'], '-', $memo->nomor);

        // Return PDF langsung tampil di browser
        return $pdf->stream('memo-' . $safeNomor . '.pdf');
    }


}