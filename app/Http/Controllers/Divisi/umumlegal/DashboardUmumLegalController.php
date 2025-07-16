<?php

namespace App\Http\Controllers\Divisi\umumlegal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardUmumLegalController extends Controller
{
    public function index()
    {
        return view('divisi.umumlegal.dashboard', ['divisi' => 'Umum dan Legal']);
    }
}
