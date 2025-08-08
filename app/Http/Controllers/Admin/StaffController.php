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
    const MAX_MANAGER = 1;
    const MAX_ASSISTANT_MANAGER = 8;

   public function index(Request $request)
{
    $query = User::with('divisi')
                ->whereIn('role', ['user', 'manager', 'asisten_manager'])
                ->orderBy('name');

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

    // Ubah angka 5 sesuai jumlah data per halaman yang diinginkan
    $users = $query->paginate(5);

    if ($request->has('search')) {
        $users->appends(['search' => $request->search]);
    }

    return view('admin.staff.index', compact('users'));
}

    public function create()
    {
        $divisis = Divisi::orderBy('urutan')->get();
        $currentManagers = User::where('role', 'manager')->count();
        $currentAssistants = User::where('role', 'asisten_manager')->count();
        
        return view('admin.staff.create', compact('divisis', 'currentManagers', 'currentAssistants'));
    }

    public function checkQuotas()
    {
        return response()->json([
            'manager_full' => User::where('role', 'manager')->count() >= self::MAX_MANAGER,
            'asisten_manager_full' => User::where('role', 'asisten_manager')->count() >= self::MAX_ASSISTANT_MANAGER
        ]);
    }

    public function store(Request $request)
    {
        if ($request->role === 'manager') {
            $currentManagers = User::where('role', 'manager')->count();
            if ($currentManagers >= self::MAX_MANAGER) {
                return back()->withInput()->withErrors([
                    'role' => 'Kuota manager sudah penuh (maksimal 1 manager)'
                ]);
            }
        }

        if ($request->role === 'asisten_manager') {
            $currentAssistants = User::where('role', 'asisten_manager')->count();
            if ($currentAssistants >= self::MAX_ASSISTANT_MANAGER) {
                return back()->withInput()->withErrors([
                    'role' => 'Kuota asisten manager sudah penuh (maksimal 8 asisten manager)'
                ]);
            }
        }

        $validationRules = [
            'name'       => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'jabatan'    => 'required|string|max:255',
            'role'       => 'required|string|in:user,manager,asisten_manager',
        ];

        if ($request->role === 'manager') {
            $validationRules['divisi_id'] = 'nullable';
        } else {
            $validationRules['divisi_id'] = 'required|exists:divisis,id';
        }

        $request->validate($validationRules);

        // Auto-fill jabatan based on role
        $jabatanValue = $request->jabatan;
        if ($request->role === 'manager') {
            $jabatanValue = 'Manager';
        } elseif ($request->role === 'asisten_manager') {
            $jabatanValue = 'Ketua';
        }

        User::create([
            'name'       => $request->name,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'jabatan'    => $jabatanValue,
            'role'       => $request->role, 
            'divisi_id'  => $request->role === 'manager' ? null : $request->divisi_id,
        ]);

        $this->clearDashboardCache();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Akun staff berhasil dibuat. Total pengguna sekarang: ' . User::count());
    }

    public function show($id)
    {
        $user = User::with('divisi')->findOrFail($id);
        return view('admin.staff.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('divisi')->findOrFail($id);
        $divisis = Divisi::orderBy('urutan')->get();
        $currentManagers = User::where('role', 'manager')->count();
        $currentAssistants = User::where('role', 'asisten_manager')->count();
        
        return view('admin.staff.edit', compact('user', 'divisis', 'currentManagers', 'currentAssistants'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->role !== $user->role) {
            if ($request->role === 'manager') {
                $currentManagers = User::where('role', 'manager')->count();
                if ($currentManagers >= self::MAX_MANAGER) {
                    return back()->withInput()->withErrors([
                        'role' => 'Kuota manager sudah penuh (maksimal 1 manager)'
                    ]);
                }
            }

            if ($request->role === 'asisten_manager') {
                $currentAssistants = User::where('role', 'asisten_manager')->count();
                if ($currentAssistants >= self::MAX_ASSISTANT_MANAGER) {
                    return back()->withInput()->withErrors([
                        'role' => 'Kuota asisten manager sudah penuh (maksimal 8 asisten manager)'
                    ]);
                }
            }
        }

        $validationRules = [
            'name'       => 'required|string|max:255',
            'username'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password'   => 'nullable|string|min:8|confirmed',
            'jabatan'    => 'required|string|max:255',
            'role'       => 'required|string|in:user,manager,asisten_manager',
        ];

        if (!in_array($request->role, ['manager', 'asisten_manager'])) {
            $validationRules['divisi_id'] = 'required|exists:divisis,id';
        } else {
            $validationRules['divisi_id'] = 'nullable';
        }

        $request->validate($validationRules);

        // Auto-fill jabatan based on role
        $jabatanValue = $request->jabatan;
        if ($request->role === 'manager') {
            $jabatanValue = 'Manager';
        } elseif ($request->role === 'asisten_manager') {
            $jabatanValue = 'Ketua';
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->jabatan = $jabatanValue;
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

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'manager' && User::where('role', 'manager')->count() <= 1) {
            return redirect()->route('admin.staff.index')
                ->with('error', 'Tidak dapat menghapus satu-satunya manager yang ada.');
        }
        
        $userName = $user->name;
        $user->delete();

        $this->clearDashboardCache();

        $remainingUsers = User::count();

        return redirect()->route('admin.staff.index')
            ->with('success', "Staff '{$userName}' berhasil dihapus. Total pengguna sekarang: {$remainingUsers}");
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $count = $users->count();

        if ($request->action === 'delete') {
            $managerCount = $users->where('role', 'manager')->count();
            $totalManagers = User::where('role', 'manager')->count();
            
            if ($managerCount > 0 && ($totalManagers - $managerCount) < 1) {
                return redirect()->route('admin.staff.index')
                    ->with('error', 'Tidak dapat menghapus semua manager. Harus ada minimal 1 manager.');
            }
        }

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

    private function clearDashboardCache()
    {
        Cache::forget('dashboard_total_users');
        Cache::forget('dashboard_active_users_today');
        Cache::forget('dashboard_user_growth_percentage');
        Cache::forget('dashboard_users_by_divisi');
    }
}