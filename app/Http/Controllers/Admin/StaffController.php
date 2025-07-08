<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::with('jabatan')
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

        return redirect()->route('admin.staff.index')->with('success', 'Akun staff berhasil dibuat.');
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

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil dihapus.');
    }
}