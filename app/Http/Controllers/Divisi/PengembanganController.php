<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;

class PengembanganController extends Controller
{
    public function index()
    {
        return view('divisi.pengembangan.dashboard', ['divisi' => 'Pengembangan Bisnis']);
    }
}
