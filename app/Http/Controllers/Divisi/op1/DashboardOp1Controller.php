<?php

namespace App\Http\Controllers\Divisi\op1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardOp1Controller extends Controller
{
     public function index()
    {
        return view('divisi.opwil1.dashboard', ['divisi' => 'Operasional Wilayah I']);
    }
}
