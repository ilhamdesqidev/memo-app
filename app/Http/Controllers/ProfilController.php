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
        $baseRoute = $this->getBaseRoute();
        
        return view('profil.index', [
            'user' => $user,
            'baseRoute' => $baseRoute
        ]);
    }
    
    public function edit(): View
    {
        $user = Auth::user();
        $baseRoute = $this->getBaseRoute();
        
        return view('profil.edit', [
            'user' => $user,
            'baseRoute' => $baseRoute
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
        ]);

        $user->update($request->only('name', 'username'));

        return redirect()->route($this->getBaseRoute().'index')
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
        $baseRoute = $this->getBaseRoute();
        
        return view('profil.signature.index', [
            'user' => $user,
            'baseRoute' => $baseRoute
        ]);
    }

    public function createSignature(): View
    {
        $baseRoute = $this->getBaseRoute();
        
        return view('profil.signature.create', [
            'baseRoute' => $baseRoute
        ]);
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
        ]);

        try {
            $user = Auth::user();
            
            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
            }
            
            $signaturePath = $request->file('signature')->store('signatures', 'public');
            $user->update(['signature' => $signaturePath]);
            
            return redirect()->route($this->getBaseRoute().'index')
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

            return redirect()->route($this->getBaseRoute().'index')
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
                
                return redirect()->route($this->getBaseRoute().'index')
                    ->with('success', 'Signature deleted successfully!');
            }
            
            return redirect()->route($this->getBaseRoute().'index')
                ->with('info', 'No signature to delete');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete signature');
        }
    }

    protected function getBaseRoute(): string
    {
        return Auth::user()->role === 'manager' ? 'manager.profil.' : 'profil.';
    }
}