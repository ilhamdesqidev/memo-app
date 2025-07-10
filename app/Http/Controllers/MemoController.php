<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use Illuminate\Support\Facades\Storage;

class MemoController extends Controller
{
   public function index()
{
    $memos = Memo::latest()->get()->map(function ($memo) {
        // Ensure tanggal is a Carbon instance
        $memo->tanggal = \Carbon\Carbon::parse($memo->tanggal);
        return $memo;
    });
    
    return view('staff.memo.index', compact('memos'));
}

    public function create()
    {
        return view('staff.memo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor' => 'required|string|max:50|unique:memos',
            'tanggal' => 'required|date',
            'kepada' => 'required|string|max:100',
            'dari' => 'required|string|max:100',
            'perihal' => 'required|string|max:200',
            'lampiran' => 'nullable|string|max:50',
            'isi' => 'required|string',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        

        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('signatures', 'public');
            $validated['signature_path'] = $signaturePath;
        }

        Memo::create($validated);

        return redirect()->route('staff.memo.index')
            ->with('success', 'Memo berhasil dibuat!');
    }

    public function show($id)
    {
        $memo = Memo::findOrFail($id);
        return view('staff.memo.show', compact('memo'));
    }

    public function edit($id)
    {
        $memo = Memo::findOrFail($id);
        return view('staff.memo.edit', compact('memo'));
    }

    public function update(Request $request, $id)
    {
        $memo = Memo::findOrFail($id);

        $validated = $request->validate([
            'nomor' => 'required|string|max:50|unique:memos,nomor,'.$id,
            'tanggal' => 'required|date',
            'kepada' => 'required|string|max:100',
            'dari' => 'required|string|max:100',
            'perihal' => 'required|string|max:200',
            'lampiran' => 'nullable|string|max:50',
            'isi' => 'required|string',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('signature')) {
            if ($memo->signature_path) {
                Storage::disk('public')->delete($memo->signature_path);
            }
            $signaturePath = $request->file('signature')->store('signatures', 'public');
            $validated['signature_path'] = $signaturePath;
        }

        $memo->update($validated);

        return redirect()->route('staff.memo.index')
            ->with('success', 'Memo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $memo = Memo::findOrFail($id);
        
        if ($memo->signature_path) {
            Storage::disk('public')->delete($memo->signature_path);
        }
        
        $memo->delete();

        return redirect()->route('staff.memo.index')
            ->with('success', 'Memo berhasil dihapus!');
    }
}