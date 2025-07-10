<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
     {
         $user = Auth::user();
         return view('profil.index', compact('user'));
     }

    public function edit()
    {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|username|max:255|unique:users,username,'.Auth::id(),
        ]);

        Auth::user()->update($request->only('name', 'username'));

        return back()->with('success', 'profil updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        return redirect('/');
    }
}
