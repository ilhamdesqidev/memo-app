<?php

namespace App\Http\Controllers\Divisi\food;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index()
    {
        $memos = Memo::where('status', 'pending')
                    ->latest()
                    ->get()
                    ->map(function($memo) {
                        $memo->tanggal = \Carbon\Carbon::parse($memo->tanggal);
                        return $memo;
                    });

        return view('divisi.food.memo.index', compact('memos'));
    }

    /**
     * Display the specified memo
     */
    public function show($id)
    {
        $memo = Memo::findOrFail($id);
        $memo->tanggal = \Carbon\Carbon::parse($memo->tanggal);

        return view('food.memo.show', compact('memo'));
    }

    /**
     * Approve the specified memo
     */
    public function approve(Request $request, $id)
    {
        $memo = Memo::findOrFail($id);
        
        $memo->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approval_date' => now(),
            'rejection_reason' => null
        ]);

        return redirect()->route('manager.memo.index')
               ->with('success', 'Memo berhasil disetujui!');
    }

    /**
     * Reject the specified memo
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $memo = Memo::findOrFail($id);
        
        $memo->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approval_date' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->route('food.memo.index')
               ->with('success', 'Memo berhasil ditolak!');
    }
}
