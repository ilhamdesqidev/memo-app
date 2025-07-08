<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Hitung total pengguna dengan role 'user' (staff)
        $totalUsers = User::where('role', 'user')->count();
        
        // Hitung user aktif hari ini (berdasarkan updated_at)
        $activeUsersToday = User::where('role', 'user')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // Hitung persentase perubahan dari bulan lalu
        $lastMonthUsers = User::where('role', 'user')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
            
        $thisMonthUsers = User::where('role', 'user')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Hitung persentase perubahan
        $userGrowthPercentage = $lastMonthUsers > 0 
            ? round((($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsersToday',
            'userGrowthPercentage'
        ));
    }
}