<?php

namespace App\Http\Controllers\Asmen;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\MemoLog;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
     public function inbox(Request $request)
{
    $user = Auth::user();
    
    $status = $request->status ?? 'diajukan';
    
    $memos = Memo::with(['dibuatOleh', 'divisiAsal'])
        ->where('divisi_tujuan', $user->divisi->nama) // Ubah ke nama divisi
        ->when($status, function($query) use ($status) {
            $query->where('status', $status);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->query());

    return view('asmen.memo.inbox', [
        'memos' => $memos,
        'title' => 'Memo Masuk',
        'currentStatus' => $status,
        'statuses' => [
            'diajukan' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi'
        ]
    ]);
}

   public function show($id)
{
    $user = Auth::user();
    $memo = Memo::with(['dibuatOleh', 'divisiAsal', 'logs.user'])->findOrFail($id);

    // Validasi otorisasi yang lebih baik
    if ($memo->divisi_tujuan !== $user->divisi->nama) {
        abort(403, 'Anda tidak memiliki akses ke memo ini.');
    }

    // Jika status sudah diproses, tetap boleh dilihat
    return view('asmen.memo.show', [
        'memo' => $memo,
        'title' => 'Detail Memo',
        'canProcess' => $memo->status === 'diajukan' // Tambahkan flag ini
    ]);
}

 public function approve(Request $request, $id)
{
    $user = Auth::user();
    $memo = Memo::findOrFail($id);

    // Validasi otorisasi
    if ($memo->divisi_tujuan !== $user->divisi->nama || $memo->status !== 'diajukan') {
        abort(403, 'Tidak dapat memproses memo ini.');
    }

    // Update data memo
    $updateData = [
        'status' => 'disetujui',
        'approved_by' => $user->id,
        'approval_date' => now()
    ];

    // Handle signature
    if ($request->has('include_signature') && $user->signature) {
        $updateData['signature_path'] = $user->signature;
        $updateData['signed_by'] = $user->id;
        $updateData['signed_at'] = now();
    }

    $memo->update($updateData);

    // Create log - dengan divisi
    MemoLog::create([
        'memo_id' => $memo->id,
        'user_id' => $user->id,
        'divisi' => $user->divisi->nama, // Pastikan ini sesuai struktur database Anda
        'aksi' => 'persetujuan',
        'catatan' => $request->catatan ?? 'Memo disetujui',
        'waktu' => now()
    ]);

    return redirect()->route('asmen.memo.inbox')
        ->with('success', 'Memo berhasil disetujui');
}

   public function reject(Request $request, $id)
{
    $request->validate([
        'alasan' => 'required|string|max:500'
    ]);

    $user = Auth::user();
    $memo = Memo::findOrFail($id);

    // Perbaikan validasi otorisasi:
    if ($memo->divisi_tujuan !== $user->divisi->nama || $memo->status !== 'diajukan') {
        abort(403, 'Unauthorized action.');
    }

    // Update status memo
    $memo->update([
        'status' => 'ditolak',
        'rejected_by' => $user->id,
        'rejection_date' => now()
    ]);

    // Buat log memo
    MemoLog::create([
        'memo_id' => $memo->id,
        'user_id' => $user->id,
        'divisi' => $user->divisi->nama, // Pastikan kolom ini ada di tabel
        'aksi' => 'penolakan',
        'catatan' => $request->alasan,
        'waktu' => now()
    ]);

    return redirect()->route('asmen.memo.inbox')
        ->with('success', 'Memo berhasil ditolak');
}

   public function requestRevision(Request $request, $id)
{
    $request->validate([
        'catatan_revisi' => 'required|string|max:500'
    ]);

    $user = Auth::user();
    $memo = Memo::findOrFail($id);

    // Debugging
    Log::info("Divisi Tujuan Memo: ".$memo->divisi_tujuan);
    Log::info("Divisi User: ".$user->divisi->nama);
    Log::info("Status Memo: ".$memo->status);

    // Validasi
    if ($memo->divisi_tujuan !== $user->divisi->nama) {
        abort(403, 'Anda tidak berhak memproses memo ini');
    }

    if (!in_array($memo->status, ['diajukan', 'revisi'])) {
        abort(403, 'Memo sudah diproses sebelumnya');
    }

    // Update memo
    $memo->update([
        'status' => 'revisi',
        'revision_requested_by' => $user->id,
        'revision_requested_at' => now()
    ]);

    // Buat log
    MemoLog::create([
        'memo_id' => $memo->id,
        'user_id' => $user->id,
        'divisi' => $user->divisi->nama,
        'aksi' => 'permintaan_revisi',
        'catatan' => $request->catatan_revisi,
        'waktu' => now()
    ]);

    return redirect()->route('asmen.memo.inbox')
        ->with('success', 'Permintaan revisi berhasil dikirim');
}

    protected function regeneratePdf($memoId)
{
    $memo = Memo::with(['logs', 'disetujuiOleh', 'ditandatanganiOleh'])->findOrFail($memoId);
    
    // Hapus file PDF lama jika ada
    if ($memo->pdf_path && Storage::exists('public/'.$memo->pdf_path)) {
        Storage::delete('public/'.$memo->pdf_path);
    }
    
    $pdf = PDF::loadView('memo.pdf', [
        'memo' => $memo,
        'include_signature' => true
    ]);
    
    $filename = 'memo_'.$memoId.'_'.time().'.pdf';
    $path = 'memo_pdfs/'.$filename;
    
    // Pastikan folder exists
    Storage::makeDirectory('public/memo_pdfs');
    
    $pdf->save(storage_path('app/public/'.$path));
    
    $memo->update(['pdf_path' => $path]);
    
    return $path;
}
}