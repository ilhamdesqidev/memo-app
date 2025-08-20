<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index()
    {
        // Ambil semua memo yang sudah selesai (disetujui atau ditolak)
        $memos = Memo::whereIn('status', ['disetujui', 'ditolak'])
            ->with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('manager.arsip.index', compact('memos'));
    }

    public function show($id)
    {
        $memo = Memo::with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh', 'logs'])
            ->findOrFail($id);

        return view('manager.arsip.show', compact('memo'));
    }
}