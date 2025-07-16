<?php

namespace App\Http\Controllers\Divisi\sipil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSipilController extends Controller
{
    public function index()
    {
        return view('divisi.sipil.dashboard', ['divisi' => 'sipil']);
    }
}
