<?php

namespace App\Http\Controllers\Asmen;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function generatePdf(Memo $memo)
{
    $user = Auth::user();

    // Validasi otorisasi
    if ($memo->dari !== $user->divisi->nama) {
        abort(403, 'Anda tidak memiliki akses ke memo ini.');
    }

    if (!in_array($memo->status, ['disetujui', 'ditolak'])) {
        abort(403, 'Hanya memo yang sudah selesai yang dapat ditampilkan.');
    }

    $memo->load(['dibuatOleh', 'divisiAsal', 'disetujuiOleh', 'ditandatanganiOleh', 'logs.user']);

    $pdf = Pdf::loadView('memo.pdf', [
        'memo' => $memo,
        'include_signature' => true
    ]);

    // 🔥 bersihkan nomor biar aman
    $cleanNomor = preg_replace('/[\/\\\\]/', '_', $memo->nomor);

    // Tampilkan langsung di browser
    return $pdf->stream("memo_arsip_{$cleanNomor}.pdf");
}


}
