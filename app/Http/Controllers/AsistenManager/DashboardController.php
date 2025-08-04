<?php

namespace App\Http\Controllers\AsistenManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Kamu bisa sesuaikan datanya nanti sesuai kebutuhan
        return view('asmen.dashboard');
    }
}
