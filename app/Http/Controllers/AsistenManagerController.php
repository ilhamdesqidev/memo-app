<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsistenManagerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $divisi = $user->divisi->nama ?? 'Unknown';

        return view('asmen.dashboard', compact('user', 'divisi'));
    }
}
