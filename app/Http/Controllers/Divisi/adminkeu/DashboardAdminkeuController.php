<?php

namespace App\Http\Controllers\Divisi\adminkeu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminkeuController extends Controller
{
     public function index()
    {
        return view('divisi.adminkeu.dashboard', ['divisi' => 'Administrasi dan Keuangan']);
    }
}
