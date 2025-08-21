<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // Query untuk memo yang sudah selesai (disetujui atau ditolak)
        $query = Memo::whereIn('status', ['disetujui', 'ditolak'])
            ->with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh']);

        // Filter berdasarkan status jika ada
        if ($request->has('status') && in_array($request->status, ['disetujui', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $memos = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('manager.arsip.index', compact('memos'));
    }

    public function show($id)
    {
        $memo = Memo::with(['divisiTujuan', 'dibuatOleh', 'disetujuiOleh', 'ditolakOleh', 'logs'])
            ->findOrFail($id);

        return view('manager.arsip.show', compact('memo'));
    }

    /**
     * Menampilkan PDF memo untuk manager
     */
    public function showPdf($id)
    {
        $memo = Memo::findOrFail($id);
        
        // Pastikan memo sudah selesai (disetujui atau ditolak)
        if (!in_array($memo->status, ['disetujui', 'ditolak'])) {
            abort(403, 'Memo belum selesai diproses');
        }

        // Pastikan file PDF ada
        if (!$memo->pdf_path || !\Illuminate\Support\Facades\Storage::exists('public/'.$memo->pdf_path)) {
            // Jika PDF tidak ada, generate ulang
            $this->regeneratePdf($memo->id);
            $memo->refresh(); // Refresh data memo
        }

        $filePath = storage_path('app/public/'.$memo->pdf_path);
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="memo_'.$memo->nomor.'.pdf"'
        ]);
    }

    /**
     * Regenerate PDF (diambil dari ManagerMemoController)
     */
    protected function regeneratePdf($memoId)
    {
        $memo = Memo::with(['logs', 'disetujuiOleh', 'ditandatanganiOleh', 'dibuatOleh'])->findOrFail($memoId);
        
        // Hapus file PDF lama jika ada
        if ($memo->pdf_path && \Illuminate\Support\Facades\Storage::exists('public/'.$memo->pdf_path)) {
            \Illuminate\Support\Facades\Storage::delete('public/'.$memo->pdf_path);
        }
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('memo.pdf', [
            'memo' => $memo,
            'include_signature' => true
        ]);
        
        $filename = 'memo_'.$memoId.'_'.time().'.pdf';
        $path = 'memo_pdfs/'.$filename;
        
        // Pastikan folder exists
        \Illuminate\Support\Facades\Storage::makeDirectory('public/memo_pdfs');
        
        $pdf->save(storage_path('app/public/'.$path));
        
        $memo->update(['pdf_path' => $path]);
        
        return $path;
    }
}