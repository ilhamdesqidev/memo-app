<?php

namespace App\Http\Controllers\Divisi\op1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index()
    {
        return view('divisi.opwil1.memo.index');
    }
}
