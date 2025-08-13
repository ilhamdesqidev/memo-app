<?php

namespace App\Http\Controllers\Asisten;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsistenMemoController extends Controller
{
      public function index()
    {
        return view('asisten.memo.index');
    }

    public function show($id)
    {
        return view('asisten.memo.show', ['id' => $id]);
    }
}
