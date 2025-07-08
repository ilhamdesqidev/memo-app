<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::with('jabatan')
            ->where('role', 'user')
            ->orderBy('name')
            ->get();

        return view('admin.staff.index', compact('users'));
    }

    public function create()
    {
        $jabatans = Jabatan::orderBy('urutan')->get();
        return view('admin.staff.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'jabatan_id' => 'required|exists:jabatans,id',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'user',
            'jabatan_id' => $request->jabatan_id,
        ]);

        // Clear cache yang berkaitan dengan statistik dashboard
        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Akun staff berhasil dibuat. Total pengguna sekarang: ' . User::where('role', 'user')->count());
    }

    public function edit($id)
    {
        $user = User::with('jabatan')->findOrFail($id);
        $jabatans = Jabatan::orderBy('urutan')->get();
        
        return view('admin.staff.edit', compact('user', 'jabatans'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'   => 'nullable|string|min:6|confirmed',
            'jabatan_id' => 'required|exists:jabatans,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->jabatan_id = $request->jabatan_id;
        
        // Only update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Clear cache yang berkaitan dengan statistik dashboard
        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')->with('success', 'Data staff berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Optional: Check if user has any related data before deletion
        // if ($user->hasRelatedData()) {
        //     return redirect()->route('admin.staff.index')->with('error', 'Staff tidak dapat dihapus karena memiliki data terkait.');
        // }
        
        $user->delete();

        // Clear cache yang berkaitan dengan statistik dashboard
        $this->clearDashboardCache();

        $remainingUsers = User::where('role', 'user')->count();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff berhasil dihapus. Total pengguna sekarang: ' . $remainingUsers);
    }

    /**
     * Clear dashboard related cache
     */
    private function clearDashboardCache()
    {
        // Clear cache keys yang berkaitan dengan statistik dashboard
        Cache::forget('dashboard_total_users');
        Cache::forget('dashboard_active_users_today');
        Cache::forget('dashboard_user_growth_percentage');
    }

    /**
     * Get total users count for API or AJAX calls
     */
    public function getTotalUsers()
    {
        $totalUsers = User::where('role', 'user')->count();
        $activeUsersToday = User::where('role', 'user')
            ->whereDate('updated_at', now()->format('Y-m-d'))
            ->count();

        return response()->json([
            'total_users' => $totalUsers,
            'active_users_today' => $activeUsersToday
        ]);
    }
}