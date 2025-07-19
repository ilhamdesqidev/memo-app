<?php

namespace App\Http\Controllers\Divisi\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemoController extends Controller
{
    /**
     * Tampilkan semua memo yang dikirim oleh divisi Marketing
     */
    public function index()
    {
        $memos = Memo::where('dari', 'Marketing dan Sales')
                     ->latest()
                     ->get();

        return view('divisi.marketing.memo.index', compact('memos'));
    }

    /**
     * Tampilkan form create memo
     */
    public function create()
    {
        $divisi = auth()->user()->divisi->nama;
        return view('memo.create', compact('divisi'));
    }

    /**
     * Simpan memo ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|unique:memos,nomor',
            'tanggal' => 'required|date',
            'kepada' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'isi' => 'required|string',
            'divisi_tujuan' => 'required|string|max:255',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $lampiranPath = null;

        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')
                                    ->storeAs('lampiran_memo', Str::uuid() . '.' . $request->file('lampiran')->getClientOriginalExtension(), 'public');
        }

        Memo::create([
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal,
            'kepada' => $request->kepada,
            'dari' => auth()->user()->divisi->nama,
            'perihal' => $request->perihal,
            'isi' => $request->isi,
            'divisi_tujuan' => $request->divisi_tujuan,
            'lampiran' => $lampiranPath,
            'status' => 'Diajukan',
        ]);

        return redirect()->route('marketing.memo.index')->with('success', 'Memo berhasil dikirim.');
    }

    /**
     * Tampilkan detail memo
     */
    public function show($id)
    {
        $memo = Memo::findOrFail($id);
        return view('divisi.marketing.memo.show', compact('memo'));
    }
}
