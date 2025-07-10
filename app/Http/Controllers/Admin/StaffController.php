<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::with('divisi')
            ->where('role', 'user')
            ->orderBy('name')
            ->get();

        return view('admin.staff.index', compact('users'));
    }

    public function create()
    {
        $divisis = Divisi::orderBy('urutan')->get();
        return view('admin.staff.create', compact('divisis'));
    }

    public function store(Request $request)
    {

        $request->validate([
    'name'       => 'required|string|max:255',
    'username'   => 'required|string|max:255|unique:users', // Ganti email dengan username
    'password'   => 'required|string|min:8|confirmed',
    'jabatan'    => 'required|string|max:255',
    'divisi_id'  => 'required|exists:divisis,id',
]);

User::create([
    'name'       => $request->name,
    'username'   => $request->username, // Ganti email dengan username
    'password'   => Hash::make($request->password),
    'jabatan'    => $request->jabatan,
    'role'       => 'user',
    'divisi_id'  => $request->divisi_id,
]);

        // Clear cache yang berkaitan dengan statistik dashboard
        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Akun staff berhasil dibuat. Total pengguna sekarang: ' . User::where('role', 'user')->count());
    }

    public function edit($id)
    {
        $user = User::with('divisi')->findOrFail($id);
        $divisis = Divisi::orderBy('urutan')->get();
        
        return view('admin.staff.edit', compact('user', 'divisis'));
    }

   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name'       => 'required|string|max:255',
        'username'   => [
            'required',
            'string',
            'max:255',
            Rule::unique('users')->ignore($user->id),
        ],
        'password'   => 'nullable|string|min:8|confirmed',
        'jabatan'    => 'required|string|max:255',
        'divisi_id'  => 'required|exists:divisis,id',
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan oleh user lain.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'jabatan.required' => 'Jabatan wajib diisi.',
        'divisi_id.required' => 'Divisi wajib dipilih.',
        'divisi_id.exists' => 'Divisi yang dipilih tidak valid.',
    ]);

    // Update user data
    $user->name = $request->name;
    $user->username = $request->username;
    $user->jabatan = $request->jabatan;
    $user->divisi_id = $request->divisi_id;
    
    // Only update password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Clear cache yang berkaitan dengan statistik dashboard
    $this->clearDashboardCache();

    return redirect()->route('admin.staff.index')
        ->with('success', 'Data staff berhasil diperbarui.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Check if user has any related data before deletion
        // You can add your own logic here based on your application needs
        // Example:
        // if ($user->hasRelatedData()) {
        //     return redirect()->route('admin.staff.index')
        //         ->with('error', 'Staff tidak dapat dihapus karena memiliki data terkait.');
        // }
        
        $userName = $user->name;
        $user->delete();

        // Clear cache yang berkaitan dengan statistik dashboard
        $this->clearDashboardCache();

        $remainingUsers = User::where('role', 'user')->count();

        return redirect()->route('admin.staff.index')
            ->with('success', "Staff '{$userName}' berhasil dihapus. Total pengguna sekarang: {$remainingUsers}");
    }

    public function show($id)
    {
        $user = User::with('divisi')->findOrFail($id);
        return view('admin.staff.show', compact('user'));
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
        Cache::forget('dashboard_users_by_divisi');
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
            'active_users_today' => $activeUsersToday,
            'users_by_divisi' => User::with('divisi')
                ->where('role', 'user')
                ->selectRaw('divisi_id, count(*) as total')
                ->groupBy('divisi_id')
                ->get()
        ]);
    }

    /**
     * Bulk actions for users
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $count = $users->count();

        switch ($request->action) {
            case 'delete':
                User::whereIn('id', $request->user_ids)->delete();
                $message = "{$count} staff berhasil dihapus.";
                break;
            case 'activate':
                // Assuming you have an 'active' column
                User::whereIn('id', $request->user_ids)->update(['active' => true]);
                $message = "{$count} staff berhasil diaktifkan.";
                break;
            case 'deactivate':
                // Assuming you have an 'active' column
                User::whereIn('id', $request->user_ids)->update(['active' => false]);
                $message = "{$count} staff berhasil dinonaktifkan.";
                break;
        }

        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')->with('success', $message);
    }
}