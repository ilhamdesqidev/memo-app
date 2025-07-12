<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminKeuController extends Controller
{
    public function index()
    {
        return view('divisi.adminkeu.dashboard', ['divisi' => 'Administrasi dan Keuangan']);
    }
}
