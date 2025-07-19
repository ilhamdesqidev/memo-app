<?php

namespace App\Http\Controllers\Divisi\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index()
    {

         $memos = Memo::where('divisi_tujuan', 'Manager')->latest()->get();
        $memos = Memo::where('status', 'pending')
                    ->latest()
                    ->get()
                    ->map(function($memo) {
                        $memo->tanggal = \Carbon\Carbon::parse($memo->tanggal);
                        return $memo;
                    });

        return view('divisi.manager.memo.index', compact('memos'));
    }

   public function create()
{
    $divisi = auth()->user()->divisi->nama;
    return view('memo.create', compact('divisi'));
}
public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'isi' => 'required',
        'divisi_tujuan' => 'required', // Pilihan divisi
    ]);

    Memo::create([
        'judul' => $request->judul,
        'isi' => $request->isi,
        'divisi_tujuan' => $request->divisi_tujuan,
        'dibuat_oleh_user_id' => auth()->id(),
    ]);

    return redirect()->back()->with('success', 'Memo berhasil dibuat.');
}

}

