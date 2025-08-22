<?php

namespace App\Http\Controllers\Asisten;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
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
}