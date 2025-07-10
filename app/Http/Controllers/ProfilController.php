<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        return redirect()->route('profil.index')->with('success', 'Profile updated successfully!');
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

    public function uploadSignature(Request $request)
    {
        $request->validate([
            'signature' => [
                'required',
                'file',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048' // 2MB max
            ]
        ], [
            'signature.required' => 'Please select a signature file.',
            'signature.image' => 'The file must be an image.',
            'signature.mimes' => 'The signature must be a PNG, JPG, or JPEG file.',
            'signature.max' => 'The signature file size must not exceed 2MB.'
        ]);

        $user = Auth::user();

        // Delete old signature if exists
        if ($user->signature && Storage::disk('public')->exists($user->signature)) {
            Storage::disk('public')->delete($user->signature);
        }

        // Store new signature
        $signaturePath = $request->file('signature')->store('signatures', 'public');

        // Update user record
        $user->update(['signature' => $signaturePath]);

        return redirect()->route('profil.index')->with('success', 'Signature uploaded successfully!');
    }

    /**
     * Save signature from canvas drawing.
     */
    public function saveSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string'
        ]);

        $user = Auth::user();

        // Delete old signature if exists
        if ($user->signature && Storage::disk('public')->exists($user->signature)) {
            Storage::disk('public')->delete($user->signature);
        }

        // Process base64 image data
        $signatureData = $request->signature_data;
        
        // Remove data:image/png;base64, prefix
        $signatureData = preg_replace('#^data:image/\w+;base64,#i', '', $signatureData);
        $signatureData = base64_decode($signatureData);

        // Generate unique filename
        $filename = 'signature_' . $user->id . '_' . time() . '.png';
        $signaturePath = 'signatures/' . $filename;

        // Save to storage
        Storage::disk('public')->put($signaturePath, $signatureData);

        // Update user record
        $user->update(['signature' => $signaturePath]);

        return redirect()->route('profil.index')->with('success', 'Signature saved successfully!');
    }

    /**
     * Delete user signature.
     */
    public function deleteSignature()
    {
        $user = Auth::user();

        if ($user->signature && Storage::disk('public')->exists($user->signature)) {
            Storage::disk('public')->delete($user->signature);
        }

        $user->update(['signature' => null]);

        return redirect()->route('profil.index')->with('success', 'Signature deleted successfully!');
    }
}
