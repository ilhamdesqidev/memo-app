<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use Illuminate\Support\Facades\Storage;

class MemoController extends Controller
{
   public function index()
{
    $memos = Memo::latest()->get()->map(function($memo) {
        $memo->tanggal = \Carbon\Carbon::parse($memo->tanggal);
        return $memo;
    });
    
    return view('staff.memo.index', compact('memos'));
}

    public function create()
    {
        return view('memo.create');
    }

 // app/Http/Controllers/MemoController.php (update store method)
public function store(Request $request)
{
    $validated = $request->validate([
        'nomor' => 'required|string|max:50|unique:memos',
        'tanggal' => 'required|date',
        'kepada' => 'required|string|max:100',
        'dari' => 'required|string|max:100',
        'perihal' => 'required|string|max:200',
        'isi' => 'required|string',
        'signature' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
    ]);

    // Set default status to pending
    $validated['status'] = 'pending';

    if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
        $path = $request->file('signature')->store('memo_signatures', 'public');
        $validated['signature'] = $path;
    }

    $memo = Memo::create($validated);
    
    return redirect()->route('staff.memo.index')
           ->with('success', 'Memo berhasil dibuat dan menunggu persetujuan!');
}

    public function show($id)
{
    $memo = Memo::findOrFail($id);
    
    // Debug lengkap
    $debug = [
        'memo' => $memo->toArray(),
        'storage_path' => $memo->signature ? storage_path('app/public/'.$memo->signature) : null,
        'file_exists' => $memo->signature ? file_exists(storage_path('app/public/'.$memo->signature)) : false,
        'public_url' => $memo->signature ? url('storage/'.$memo->signature) : null
    ];
    
    logger()->info('Memo show debug', $debug);
    
    return view('staff.memo.show', [
        'memo' => $memo,
        'debug' => $debug // Hanya untuk development
    ]);
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