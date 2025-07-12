<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UmumLegalController extends Controller
{
    public function index()
    {
        return view('divisi.umumlegal.dashboard', ['divisi' => 'Umum dan Legal']);
    }
}
