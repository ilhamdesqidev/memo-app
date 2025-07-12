<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SipilController extends Controller
{
    public function index()
    {
        return view('divisi.sipil.dashboard', ['divisi' => 'sipil']);
    }
}
