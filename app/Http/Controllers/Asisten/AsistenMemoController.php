<?php

namespace App\Http\Controllers\Asisten;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AsistenMemoController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $currentDivisi = $user->divisi->nama;
    
    $query = Memo::with(['dibuatOleh', 'logs'])
        ->where(function($query) use ($currentDivisi) {
            // Memo yang berasal dari divisi asisten saat ini
            $query->where('dari', $currentDivisi)
                  // ATAU memo yang memiliki log dari divisi ini
                  ->orWhereHas('logs', function($q) use ($currentDivisi) {
                      $q->where('divisi', $currentDivisi);
                  });
        });
    
    // Filter berdasarkan status jika ada parameter status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }
    
    // Filter pencarian berdasarkan nomor atau perihal
    if ($request->has('search') && $request->search != '') {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('nomor', 'like', '%'.$searchTerm.'%')
              ->orWhere('perihal', 'like', '%'.$searchTerm.'%');
        });
    }
    
    $memos = $query->orderBy('created_at', 'desc')->paginate(10);
    
    return view('asisten.memo.index', [
        'memos' => $memos,
        'currentDivisi' => $currentDivisi
    ]);
}

   public function show($id)
{
    $user = Auth::user();
    $currentDivisi = $user->divisi->nama;
    $memo = Memo::with(['dibuatOleh', 'logs.user'])->findOrFail($id);

    // Validasi akses yang lebih fleksibel
    $isAllowed = $memo->dari === $currentDivisi || 
                $memo->divisi_tujuan === $currentDivisi ||
                $memo->logs()->where('divisi', $currentDivisi)->exists();

    if (!$isAllowed) {
        abort(403, 'Anda tidak memiliki akses ke memo ini.');
    }

    return view('asisten.memo.show', [
        'memo' => $memo,
        'currentDivisi' => $currentDivisi
    ]);
}

public function viewPdf($id)
{
    $memo = Memo::with(['dibuatOleh', 'disetujuiOleh', 'logs'])->findOrFail($id);
    $currentDivisi = auth()->user()->divisi->nama;
    
    // Validasi akses
    $isAllowed = $memo->dari === $currentDivisi || 
                $memo->divisi_tujuan === $currentDivisi ||
                $memo->logs()->where('divisi', $currentDivisi)->exists();
    
    if (!$isAllowed) {
        abort(403, 'Anda tidak memiliki akses ke memo ini.');
    }

    // Generate PDF jika belum ada
    if (!$memo->pdf_path || !Storage::exists('public/'.$memo->pdf_path)) {
        $this->generatePdf($memo->id);
        $memo->refresh();
    }

    $pdfPath = storage_path('app/public/'.$memo->pdf_path);
    
    return response()->file($pdfPath, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="memo-'.$memo->nomor.'.pdf"'
    ]);
}

 public function generatePdf($id)
    {
        $memo = Memo::with(['disetujuiOleh', 'ditandatanganiOleh'])->findOrFail($id);
        
        $pdf = PDF::loadView('memo.pdf', compact('memo'))
                  ->setPaper('a4')
                  ->setOption('isHtml5ParserEnabled', true)
                  ->setOption('isRemoteEnabled', true);
        
        $folder = storage_path('app/public/memo_pdfs');
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }
        
        $filename = 'memo_'.$id.'.pdf';
        $path = 'memo_pdfs/'.$filename;
        $fullPath = storage_path('app/public/'.$path);
        
        $pdf->save($fullPath);
        
        $memo->update(['pdf_path' => $path]);
        
        return $path;
    }
}