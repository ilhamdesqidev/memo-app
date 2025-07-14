<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class ProfilController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $user = Auth::user();
        return view('profil.index', compact('user'));
    }
    
    public function dashboard(): View
    {
        $user = Auth::user();
        return view('profil.dashboard', compact('user'));
    }
    
    public function edit(): View
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        return view('profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
        ]);

        $user->update($request->only('name', 'username'));

        return redirect()->route('profil.index')
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $this->authorize('delete', $user);
        
        $request->validate([
            'password' => 'required|current_password',
        ]);

        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Account deleted successfully');
    }

    public function signatureIndex(): View
    {
        $user = Auth::user();
        return view('profil.signature.index', compact('user'));
    }

    public function createSignature(): View
    {
        return view('profil.signature.create');
    }

    public function uploadSignature(Request $request)
    {
        $request->validate([
            'signature' => [
                'required',
                'file',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048'
            ]
        ], [
            'signature.required' => 'Please select a signature file.',
            'signature.image' => 'The file must be an image.',
            'signature.mimes' => 'The signature must be a PNG, JPG, or JPEG file.',
            'signature.max' => 'The signature file size must not exceed 2MB.'
        ]);

        try {
            $user = Auth::user();
            
            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
            }
            
            $signaturePath = $request->file('signature')->store('signatures', 'public');
            $user->update(['signature' => $signaturePath]);
            
            return redirect()->route('profil.index')
                ->with('success', 'Signature uploaded successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload signature');
        }
    }

    public function saveSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string'
        ]);

        try {
            $user = Auth::user();

            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
            }

            $signatureData = $request->signature_data;
            $signatureData = preg_replace('#^data:image/\w+;base64,#i', '', $signatureData);
            $signatureData = base64_decode($signatureData);

            if (!$signatureData) {
                throw new \Exception('Invalid image data');
            }

            $filename = 'signature_'.$user->id.'_'.time().'.png';
            $signaturePath = 'signatures/'.$filename;
            
            Storage::disk('public')->put($signaturePath, $signatureData);
            $user->update(['signature' => $signaturePath]);

            return redirect()->route('profil.index')
                ->with('success', 'Signature saved successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save signature');
        }
    }

    public function deleteSignature()
    {
        try {
            $user = Auth::user();
            
            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
                $user->update(['signature' => null]);
                
                return redirect()->route('profil.index')
                    ->with('success', 'Signature deleted successfully!');
            }
            
            return redirect()->route('profil.index')
                ->with('info', 'No signature to delete');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete signature');
        }
    }
}