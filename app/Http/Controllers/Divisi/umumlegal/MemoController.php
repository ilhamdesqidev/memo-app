<?php

namespace App\Http\Controllers\Divisi\umumlegal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    /**
     * Display the marketing memo page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('divisi.umumlegal.memo.index');
    }
    public function create()
{
    $divisi = auth()->user()->divisi->nama;
    return view('memo.create', compact('divisi'));
}
}
