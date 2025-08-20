<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $memos = Memo::where(function($query) {
                $query->where('status', 'approved')
                      ->orWhere('status', 'disetujui');
            })
            ->where('dibuat_oleh_user_id', Auth::id())
            ->with('divisiTujuan') // Ganti dengan relasi yang benar
            ->with('dibuatOleh') // Tambahkan relasi pembuat jika diperlukan
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('staff.arsip.index', compact('memos'));
    }
}