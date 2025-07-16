<?php

namespace App\Http\Controllers\Divisi\adminkeu;

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
        return view('divisi.adminkeu.memo.index');
    }
}
