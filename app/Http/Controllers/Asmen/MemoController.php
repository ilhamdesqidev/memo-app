<?php

namespace App\Http\Controllers\Asmen;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    public function inbox(Request $request)
    {
        $divisiId = Auth::user()->divisi_id;
        
        $memos = Memo::with(['pengirim', 'tujuanDivisi'])
            ->where('divisi_tujuan', $divisiId)
            ->where('status', '!=', 'draft')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('asmen.memo.inbox', [
            'memos' => $memos,
            'title' => 'Memo Masuk'
        ]);
    }
}