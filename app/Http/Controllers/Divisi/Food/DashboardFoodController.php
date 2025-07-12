<?php

namespace App\Http\Controllers\Divisi\food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardFoodController extends Controller
{
    public function index()
    {
        return view('divisi.food.dashboard', ['divisi' => 'Food Beverage']);
    }
}
