<?php

namespace App\Http\Controllers\Divisi\op2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * Display the memo page for Operasional Wilayah II.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('divisi.opwil2.memo.index');
    }
    public function create()
{
    $divisi = auth()->user()->divisi->nama;
    return view('memo.create', compact('divisi'));
}
}
