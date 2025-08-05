<?php

namespace App\Http\Controllers\Asmen;  // Pastikan namespace ini benar

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // Mengembalikan view tanpa data
        return view('asmen.arsip.index');
    }


    // Tambahkan method lainnya sesuai kebutuhan
}