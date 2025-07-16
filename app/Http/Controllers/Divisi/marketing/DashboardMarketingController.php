<?php

namespace App\Http\Controllers\Divisi\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardMarketingController extends Controller
{
     public function index()
    {
        return view('divisi.marketing.dashboard', ['divisi' => 'Marketing dan Sales']);
    }
}
