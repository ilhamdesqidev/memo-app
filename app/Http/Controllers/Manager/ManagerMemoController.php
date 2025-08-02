<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;

class ManagerMemoController extends Controller
{
    public function index()
    {
        // Logic to display memos for managers
        return view('manager.memo.index');
    }

    public function inbox()
    {
        // Logic to display the inbox for managers
        return view('manager.memo.inbox');
    }
}
