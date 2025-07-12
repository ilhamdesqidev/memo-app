<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        return view('divisi.manager.dashboard', ['divisi' => 'Manager']);
    }
}
