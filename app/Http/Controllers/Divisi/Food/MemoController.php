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

   public function create()
{
    $divisi = auth()->user()->divisi->nama;
    return view('memo.create', compact('divisi'));
}
}
