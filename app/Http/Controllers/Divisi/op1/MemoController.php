<?php

namespace App\Http\Controllers\Divisi\op1;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Divisi;
use Illuminate\Http\Request;

class MemoController extends Controller
{
   public function index()
    {
        $memos = Memo::where('divisi_tujuan', auth()->user()->divisi->nama)
                   ->orWhere('dari', auth()->user()->divisi->nama)
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
        
        return view('divisi.opwil1.memo.index', compact('memos'));
    }

    public function create()
    {
        $divisiTujuan = Divisi::where('nama', '!=', auth()->user()->divisi->nama)->get();
        return view('memo.create', compact('divisiTujuan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor' => 'required|string|max:50|unique:memos',
            'tanggal' => 'required|date',
            'kepada' => 'required|string|max:100',
            'perihal' => 'required|string|max:255',
            'divisi_tujuan' => 'required|string',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $memoData = $request->only([
            'nomor', 'tanggal', 'kepada', 'perihal', 
            'divisi_tujuan', 'isi'
        ]);
        
        $memoData['dari'] = auth()->user()->divisi->nama;
        $memoData['dibuat_oleh_user_id'] = auth()->id();

        if ($request->hasFile('lampiran')) {
            $memoData['lampiran'] = $request->file('lampiran')
                ->store('lampiran', 'public');
        }

        Memo::create($memoData);

        return redirect()
               ->route('opwil1.memo.index')
               ->with('success', 'Memo berhasil dibuat');
    }
// In your MemoController for opwil1
public function show($id)
{
    $memo = Memo::findOrFail($id);
    
    // Verify the memo belongs to the current user's division
    if ($memo->divisi_tujuan !== auth()->user()->divisi->nama && 
        $memo->dari !== auth()->user()->divisi->nama) {
        abort(403, 'Unauthorized action.');
    }

    return view('divisi.opwil1.memo.show', compact('memo'));
}
}
