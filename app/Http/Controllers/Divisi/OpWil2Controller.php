<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpWil2Controller extends Controller
{
    public function index()
    {
        return view('divisi.opwil2.dashboard', ['divisi' => 'Operasional Wilayah II']);
    }
}
