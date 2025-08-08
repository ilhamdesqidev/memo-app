<?php

namespace App\Http\Controllers\Asisten;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $divisi = $user->divisi->nama ?? 'Unknown';

        return view('asisten.dashboard');
    }
}
