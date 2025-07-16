<?php

namespace App\Http\Controllers\Divisi\pengembangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardPengembanganController extends Controller
{
     public function index()
    {
        return view('divisi.pengembangan.dashboard', ['divisi' => 'Pengembangan Bisnis']);
    }
}
