<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Divisi;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function index()
     {
         $user = Auth::user();
         return view('profile.index', compact('user'));
     }

    public function edit()
    {
        $user = Auth::user();
        $divisis = Divisi::all(); // ambil semua divisi dari database
        return view('profile.edit', compact('user', 'divisis'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|username|max:255|unique:users,username,'.Auth::id(),
        ]);

        Auth::user()->update($request->only('name', 'username'));

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
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
