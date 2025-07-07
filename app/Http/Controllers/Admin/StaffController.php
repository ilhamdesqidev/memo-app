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
        $staffs = \App\Models\User::with('jabatan')
            ->where('role', 'user')
            ->orderBy('name')
            ->get();

        return view('admin.staff.index', compact('staffs'));
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
}
