<?php

namespace App\Http\Controllers\Divisi\sipil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemoController extends Controller
{
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
