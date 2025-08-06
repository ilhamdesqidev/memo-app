<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\MemoLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMemoController extends Controller
{
    public function inbox()
    {
        $memos = Memo::with(['dibuatOleh', 'divisiAsal'])
            ->where('divisi_tujuan', 'Manager')
            ->where('status', 'diajukan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('manager.memo.inbox', [
            'memos' => $memos,
            'title' => 'Memo Masuk - Manager'
        ]);
    }

    public function show($id)
    {
        $memo = Memo::with(['dibuatOleh', 'divisiAsal', 'logs.user'])->findOrFail($id);
        
        // Pastikan memo ditujukan ke Manager
        if ($memo->divisi_tujuan !== 'Manager') {
            abort(403, 'Anda tidak memiliki akses ke memo ini.');
        }

        return view('manager.memo.show', [
            'memo' => $memo,
            'title' => 'Detail Memo - Manager',
            'canProcess' => $memo->status === 'diajukan'
        ]);
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        $memo = Memo::findOrFail($id);

        // Validasi
        if ($memo->divisi_tujuan !== 'Manager' || $memo->status !== 'diajukan') {
            abort(403, 'Tidak dapat memproses memo ini.');
        }

        // Update memo
        $memo->update([
            'status' => 'disetujui',
            'approved_by' => $user->id,
            'approval_date' => now()
        ]);

        // Buat log
        MemoLog::create([
            'memo_id' => $memo->id,
            'user_id' => $user->id,
            'divisi' => 'Manager',
            'aksi' => 'persetujuan_final',
            'catatan' => $request->catatan ?? 'Memo disetujui oleh Manager',
            'waktu' => now()
        ]);

        return redirect()->route('manager.memo.inbox')
            ->with('success', 'Memo berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $user = Auth::user();
        $memo = Memo::findOrFail($id);

        // Validasi
        if ($memo->divisi_tujuan !== 'Manager' || $memo->status !== 'diajukan') {
            abort(403, 'Tidak dapat memproses memo ini.');
        }

        // Update memo
        $memo->update([
            'status' => 'ditolak',
            'rejected_by' => $user->id,
            'rejection_date' => now()
        ]);

        // Buat log
        MemoLog::create([
            'memo_id' => $memo->id,
            'user_id' => $user->id,
            'divisi' => 'Manager',
            'aksi' => 'penolakan_final',
            'catatan' => $request->alasan,
            'waktu' => now()
        ]);

        return redirect()->route('manager.memo.inbox')
            ->with('success', 'Memo berhasil ditolak');
    }
}