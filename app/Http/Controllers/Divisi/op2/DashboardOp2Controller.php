<?php

namespace App\Http\Controllers\Divisi\op2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardOp2Controller extends Controller
{
     public function index()
    {
        return view('divisi.opwil2.dashboard', ['divisi' => 'Operasional Wilayah II']);
    }
}
