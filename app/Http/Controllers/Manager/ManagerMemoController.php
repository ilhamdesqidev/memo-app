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

        $request->validate([
            'divisi_tujuan' => 'required|exists:divisis,nama',
            'include_signature' => 'nullable|boolean'
        ]);

        $divisiTujuan = $request->input('divisi_tujuan');

        // Cari Asisten Manager dari divisi tujuan
        $asmen = \App\Models\User::where('divisi_id', function($query) use ($divisiTujuan) {
                $query->select('id')->from('divisis')->where('nama', $divisiTujuan);
            })
            ->where('role', 'asisten_manager')
            ->first();

        if (!$asmen) {
            return back()->with('error', 'Divisi tujuan tidak memiliki Asisten Manager yang aktif');
        }

        // Update data memo
        $updateData = [
            'status' => 'diajukan',
            'divisi_tujuan' => $divisiTujuan,
            'kepada' => $asmen->name,
            'kepada_id' => $asmen->id,
            'forwarded_by' => $user->id,
            'forwarded_at' => now(),
            'approved_by' => $user->id,
            'approval_date' => now()
        ];

        // Handle manager signature jika diminta
        if ($request->has('include_signature') && $request->include_signature) {
            if ($user->signature) {
                // Simpan tanda tangan manager di field khusus manager
                $updateData['manager_signature_path'] = $user->signature;
                $updateData['manager_signed_at'] = now();
                $updateData['manager_signed'] = true;
                
                // Jangan timpa tanda tangan creator
                // $updateData['signature_path'] = $user->signature; // HAPUS BARIS INI
                // $updateData['signed_by'] = $user->id; // HAPUS BARIS INI
                // $updateData['signed_at'] = now(); // HAPUS BARIS INI
            } else {
                return back()->with('error', 'Anda belum memiliki tanda tangan digital. Silakan buat tanda tangan terlebih dahulu.');
            }
        }

        $memo->update($updateData);

        // Pastikan tanda tangan creator tetap ada
        $this->saveCreatorSignature($memo);

        // Create log
        $logMessage = $request->has('include_signature') && $request->include_signature 
            ? "Memo disetujui dengan tanda tangan dan diteruskan ke Asisten Manager $divisiTujuan"
            : "Memo disetujui dan diteruskan ke Asisten Manager $divisiTujuan";

        MemoLog::create([
            'memo_id' => $memo->id,
            'user_id' => $user->id,
            'divisi' => 'Manager',
            'aksi' => 'penerusan_ke_divisi',
            'catatan' => $request->catatan ?? $logMessage,
            'waktu' => now()
        ]);

        // Regenerate PDF dengan tanda tangan baru
        $this->regeneratePdf($memo->id);

        return redirect()->route('manager.memo.inbox')
            ->with('success', $logMessage);
    }

    /**
     * Simpan tanda tangan pembuat memo jika belum ada
     */
    protected function saveCreatorSignature(Memo $memo)
    {
        // Jika belum ada creator signature, simpan dari pembuat memo
        if (!$memo->signature_path && $memo->dibuatOleh && $memo->dibuatOleh->signature) {
            $memo->update([
                'signature_path' => $memo->dibuatOleh->signature,
                'creator_signed_at' => $memo->created_at ?? now()
            ]);
        }
    }

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

    /**
     * Method untuk menandatangani memo oleh manager
     */
    public function signMemo(Request $request, $id)
    {
        $user = Auth::user();
        $memo = Memo::findOrFail($id);

        // Validasi
        if ($memo->divisi_tujuan !== 'Manager' || $memo->status !== 'diajukan') {
            abort(403, 'Tidak dapat memproses memo ini.');
        }

        if (!$user->signature) {
            return back()->with('error', 'Anda belum memiliki tanda tangan digital.');
        }

        // Simpan tanda tangan creator jika belum ada
        $this->saveCreatorSignature($memo);

        // Update dengan tanda tangan manager
        $memo->update([
            'manager_signature_path' => $user->signature,
            'manager_signed_at' => now(),
            'manager_signed' => true,
            'signed_by' => $user->id,
            'signed_at' => now()
        ]);

        // Create log
        MemoLog::create([
            'memo_id' => $memo->id,
            'user_id' => $user->id,
            'divisi' => 'Manager',
            'aksi' => 'penandatanganan',
            'catatan' => 'Memo ditandatangani oleh Manager',
            'waktu' => now()
        ]);

        // Regenerate PDF
        $this->regeneratePdf($memo->id);

        return back()->with('success', 'Memo berhasil ditandatangani');
    }
}