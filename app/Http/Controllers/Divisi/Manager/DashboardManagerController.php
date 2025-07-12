<?php

namespace App\Http\Controllers\divisi\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardManagerController extends Controller
{
    public function index()
    {
        return view('divisi.manager.dashboard', ['divisi' => 'Manager']);
    }
}
