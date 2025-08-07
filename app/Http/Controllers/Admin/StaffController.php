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
    /**
     * Menampilkan daftar staff dengan pagination dan search
     */
    public function index(Request $request)
    {
        // Start building the query
        $query = User::with('divisi')
                    ->whereIn('role', ['user', 'manager', 'asisten_manager'])
                    ->orderBy('name');

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%$searchTerm%")
                  ->orWhere('username', 'like', "%$searchTerm%")
                  ->orWhere('jabatan', 'like', "%$searchTerm%")
                  ->orWhereHas('divisi', function($q) use ($searchTerm) {
                      $q->where('nama', 'like', "%$searchTerm%");
                  });
            });
        }

        // Paginate the results (5 items per page)
        $users = $query->paginate(15);

        // Pass the search term back to view to repopulate the search input
        if ($request->has('search')) {
            $users->appends(['search' => $request->search]);
        }

        return view('admin.staff.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat staff baru
     */
    public function create()
    {
        $divisis = Divisi::orderBy('urutan')->get();
        return view('admin.staff.create', compact('divisis'));
    }

    /**
     * Menyimpan staff baru ke database
     */
    public function store(Request $request)
    {
        $validationRules = [
            'name'       => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'jabatan'    => 'required|string|max:255', // Diubah menjadi input text biasa
            'role'       => 'required|string|in:user,manager,asisten_manager',
        ];

        // Only require divisi_id if role is not manager
        if ($request->role === 'manager') {
            $validationRules['divisi_id'] = 'nullable';
        } else {
            $validationRules['divisi_id'] = 'required|exists:divisis,id';
        }

        $request->validate($validationRules);

        User::create([
            'name'       => $request->name,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'jabatan'    => $request->jabatan,
            'role'       => $request->role, 
            'divisi_id'  => $request->role === 'manager' ? null : $request->divisi_id,
        ]);

        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Akun staff berhasil dibuat. Total pengguna sekarang: ' . User::count());
    }

    /**
     * Menampilkan detail staff
     */
    public function show($id)
    {
        $user = User::with('divisi')->findOrFail($id);
        return view('admin.staff.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit staff
     */
    public function edit($id)
    {
        $user = User::with('divisi')->findOrFail($id);
        $divisis = Divisi::orderBy('urutan')->get();
        
        return view('admin.staff.edit', compact('user', 'divisis'));
    }

    /**
     * Mengupdate data staff di database
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validationRules = [
            'name'       => 'required|string|max:255',
            'username'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password'   => 'nullable|string|min:8|confirmed',
            'jabatan'    => 'required|string|max:255', // Diubah menjadi input text biasa
            'role'       => 'required|string|in:user,manager,asisten_manager',
        ];

        // Only require divisi_id if role is not manager or asisten_manager
        if (!in_array($request->role, ['manager', 'asisten_manager'])) {
            $validationRules['divisi_id'] = 'required|exists:divisis,id';
        } else {
            $validationRules['divisi_id'] = 'nullable';
        }

        $request->validate($validationRules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh user lain.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'divisi_id.required' => 'Divisi wajib dipilih.',
            'divisi_id.exists' => 'Divisi yang dipilih tidak valid.',
            'role.required' => 'Role wajib dipilih.',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->jabatan = $request->jabatan;
        $user->role = $request->role;
        $user->divisi_id = in_array($request->role, ['manager', 'asisten_manager']) ? null : $request->divisi_id;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Data staff berhasil diperbarui.');
    }

    /**
     * Menghapus staff dari database
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        // Clear cache yang berkaitan dengan statistik dashboard
        $this->clearDashboardCache();

        $remainingUsers = User::count();

        return redirect()->route('admin.staff.index')
            ->with('success', "Staff '{$userName}' berhasil dihapus. Total pengguna sekarang: {$remainingUsers}");
    }

    /**
     * Bulk action untuk multiple staff
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
                User::whereIn('id', $request->user_ids)->update(['active' => true]);
                $message = "{$count} staff berhasil diaktifkan.";
                break;
            case 'deactivate':
                User::whereIn('id', $request->user_ids)->update(['active' => false]);
                $message = "{$count} staff berhasil dinonaktifkan.";
                break;
        }

        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')->with('success', $message);
    }

    /**
     * Mendapatkan total users untuk dashboard
     */
    public function getTotalUsers()
    {
        $totalUsers = User::count();
        $activeUsersToday = User::whereDate('updated_at', now()->format('Y-m-d'))
            ->count();

        return response()->json([
            'total_users' => $totalUsers,
            'active_users_today' => $activeUsersToday,
            'users_by_divisi' => User::with('divisi')
                ->selectRaw('divisi_id, count(*) as total')
                ->groupBy('divisi_id')               
                ->get()
        ]);
    }

    /**
     * Membersihkan cache dashboard
     */
    private function clearDashboardCache()
    {
        // Clear cache keys yang berkaitan dengan statistik dashboard
        Cache::forget('dashboard_total_users');
        Cache::forget('dashboard_active_users_today');
        Cache::forget('dashboard_user_growth_percentage');
        Cache::forget('dashboard_users_by_divisi');
    }
}