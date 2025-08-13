<?php

namespace App\Http\Controllers\Asisten;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsistenMemoController extends Controller
{
      public function index()
    {
        return view('asisten.index');
    }

    public function show($id)
    {
        return view('asisten.show', ['id' => $id]);
    }
}
