<?php

namespace App\Http\Controllers\Asmen;

use App\Http\Controllers\Controller;
use App\Models\Memo;
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
}