<?php

namespace App\Http\Controllers\Asmen;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\MemoLog;
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

    // Proses approval
    $memo->update([
        'status' => 'disetujui',
        'approved_by' => $user->id,
        'approval_date' => now()
    ]);

    return redirect()->route('asmen.memo.inbox')
        ->with('success', 'Memo berhasil disetujui');
}

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $memo = Memo::findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if ($memo->divisi_tujuan != $user->divisi_id || 
            $memo->status != 'diajukan') {
            abort(403, 'Unauthorized action.');
        }

        // Update memo status
        $memo->status = 'ditolak';
        $memo->save();

        // Log the rejection
        MemoLog::create([
            'memo_id' => $memo->id,
            'user_id' => $user->id,
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

        $memo = Memo::findOrFail($id);
        $user = Auth::user();

        // Authorization check
        if ($memo->divisi_tujuan != $user->divisi_id || 
            $memo->status != 'diajukan') {
            abort(403, 'Unauthorized action.');
        }

        // Update memo status
        $memo->status = 'revisi';
        $memo->save();

        // Log the revision request
        MemoLog::create([
            'memo_id' => $memo->id,
            'user_id' => $user->id,
            'aksi' => 'permintaan_revisi',
            'catatan' => $request->catatan_revisi,
            'waktu' => now()
        ]);

        return redirect()->route('asmen.memo.inbox')
            ->with('success', 'Permintaan revisi berhasil dikirim');
    }
}