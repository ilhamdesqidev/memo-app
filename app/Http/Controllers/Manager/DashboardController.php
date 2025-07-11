<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingMemos = Memo::where('status', 'pending')->count();
        $approvedMemos = Memo::where('status', 'approved')->count();
        $rejectedMemos = Memo::where('status', 'rejected')->count();

        return view('manager.dashboard', [
            'pendingMemos' => $pendingMemos,
            'approvedMemos' => $approvedMemos,
            'rejectedMemos' => $rejectedMemos
        ]);
    }
}