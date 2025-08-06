<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\MemoLog;
use App\Models\Divisi;
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

        // Dapatkan semua divisi kecuali divisi pengirim
        $otherDivisions = Divisi::where('nama', '!=', $memo->dari)->get();

        return view('manager.memo.show', [
            'memo' => $memo,
            'title' => 'Detail Memo - Manager',
            'canProcess' => $memo->status === 'diajukan',
            'otherDivisions' => $otherDivisions
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

        // Tentukan divisi tujuan jika ada
        $divisiTujuan = $request->input('divisi_tujuan');
        
        // Update data memo
        $updateData = [
            'approved_by' => $user->id,
            'approval_date' => now(),
            'status' => $divisiTujuan ? 'diajukan' : 'disetujui'
        ];

        // Jika ada divisi tujuan, update
        if ($divisiTujuan) {
            $updateData['divisi_tujuan'] = $divisiTujuan;
        }

        // Handle signature
        if ($request->has('include_signature') && $user->signature) {
            $updateData['signature_path'] = $user->signature;
            $updateData['signed_by'] = $user->id;
            $updateData['signed_at'] = now();
        }

        $memo->update($updateData);

        // Create log
        $logMessage = $divisiTujuan 
            ? "Memo disetujui dan diteruskan ke divisi $divisiTujuan" 
            : 'Memo disetujui oleh Manager';
        
        MemoLog::create([
            'memo_id' => $memo->id,
            'user_id' => $user->id,
            'divisi' => 'Manager',
            'aksi' => $divisiTujuan ? 'penerusan' : 'persetujuan_final',
            'catatan' => $request->catatan ?? $logMessage,
            'waktu' => now()
        ]);

        return redirect()->route('manager.memo.inbox')
            ->with('success', $divisiTujuan 
                ? "Memo berhasil disetujui dan diteruskan ke $divisiTujuan" 
                : 'Memo berhasil disetujui');
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