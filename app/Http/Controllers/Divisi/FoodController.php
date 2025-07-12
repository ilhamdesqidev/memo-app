<?php

namespace App\Http\Controllers\Divisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        return view('divisi.food.dashboard', ['divisi' => 'Food Beverage']);
    }
}
