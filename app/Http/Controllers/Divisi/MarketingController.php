<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function index()
    {
        return view('divisi.marketing.dashboard', ['divisi' => 'Marketing dan Sales']);
    }
}
