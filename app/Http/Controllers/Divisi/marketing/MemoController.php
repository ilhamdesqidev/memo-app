<?php

namespace App\Http\Controllers\Divisi\marketing;

use App\Http\Controllers\Controller;
use App\Models\Memo;

use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * Display the marketing memo page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
         $memos = Memo::where('divisi_tujuan', 'Marketing dan Sales')->latest()->get();
        return view('divisi.marketing.memo.index', compact( 'memos'));
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
