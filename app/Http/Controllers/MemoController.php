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
        'isi' => 'required|string',
        'signature' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
    ]);

    // Debug sebelum proses
    logger()->info('Signature upload attempt', [
        'hasFile' => $request->hasFile('signature'),
        'fileValid' => $request->file('signature')?->isValid(),
        'originalName' => $request->file('signature')?->getClientOriginalName()
    ]);

    if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
        try {
            $path = $request->file('signature')->store('memo_signatures', 'public');
            $validated['signature'] = $path;
            
            logger()->info('File stored successfully', [
                'path' => $path,
                'full_path' => storage_path('app/public/'.$path)
            ]);
        } catch (\Exception $e) {
            logger()->error('File storage failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    $memo = Memo::create($validated);
    
    // Debug setelah create
    logger()->info('Memo created', $memo->toArray());
    
    return redirect()->route('staff.memo.show', $memo->id)
           ->with('success', 'Memo berhasil dibuat!');
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