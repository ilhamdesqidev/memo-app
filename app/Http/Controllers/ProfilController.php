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

    // Method untuk mendapatkan semua route yang diperlukan
    protected function getAllRoutes(): array
    {
        return [
            'profil' => [
                'index' => 'profil.index',
                'edit' => 'profil.edit',
                'update' => 'profil.update',
                'destroy' => 'profil.destroy'
            ],
            'signature' => [
                'index' => 'profil.signature.index',
                'create' => 'profil.signature.create',
                'upload' => 'profil.signature.upload',
                'save' => 'profil.signature.save',
                'delete' => 'profil.signature.delete'
            ]
        ];
    }

    // Tampilan utama profil
    public function index(): View
    {
        $user = Auth::user();
        $routes = $this->getAllRoutes();
        
        return view('profil.index', [
            'user' => $user,
            'routes' => $routes
        ]);
    }
    
    // Tampilan edit profil
    public function edit(): View
    {
        $user = Auth::user();
        $routes = $this->getAllRoutes();
        
        return view('profil.edit', [
            'user' => $user,
            'routes' => $routes
        ]);
    }

    // Update profil
    public function update(Request $request)
    {
        $user = Auth::user();
        $routes = $this->getAllRoutes();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
        ]);

        $user->update($request->only('name', 'username'));

        return redirect()->route($routes['profil']['index'])
            ->with('success', 'Profil updated successfully!');
    }

    // Hapus akun
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

    // Tampilan index signature
    public function signatureIndex(): View
    {
        $user = auth()->user();
        $routes = $this->getAllRoutes();
        
        return view('profil.signature.index', [
            'user' => $user,
            'routes' => $routes
        ]);
    }

    // Tampilan create signature
    public function createSignature(): View
    {
        $user = Auth::user();
        $routes = $this->getAllRoutes();
        
        return view('profil.signature.create', [
            'user' => $user,
            'routes' => $routes
        ]);
    }

    // Upload signature dari file
    public function uploadSignature(Request $request)
    {
        $request->validate([
            'signature' => [
                'required',
                'file',
                'image',
                'mimes:png,jpg,jpeg',
                'max:5096' // 5MB
            ]
        ]);

        try {
            $user = Auth::user();
            $routes = $this->getAllRoutes();
            
            // Hapus signature lama jika ada
            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
            }
            
            // Simpan file baru
            $signaturePath = $request->file('signature')->store('signatures', 'public');
            $user->update(['signature' => $signaturePath]);
            
            return redirect()->route($routes['signature']['index'])
                ->with('success', 'Signature uploaded successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload signature: '.$e->getMessage());
        }
    }

    // Simpan signature dari canvas drawing
    public function saveSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string'
        ]);

        try {
            $user = Auth::user();
            $routes = $this->getAllRoutes();

            // Hapus signature lama jika ada
            if ($user->signature) {
                Storage::disk('public')->delete($user->signature);
            }

            // Proses data base64
            $signatureData = $request->signature_data;
            $signatureData = preg_replace('#^data:image/\w+;base64,#i', '', $signatureData);
            $signatureData = base64_decode($signatureData);

            if (!$signatureData) {
                throw new \Exception('Invalid image data');
            }

            // Generate nama file unik
            $filename = 'signature_'.$user->id.'_'.time().'.png';
            $signaturePath = 'signatures/'.$filename;
            
            // Simpan ke storage
            Storage::disk('public')->put($signaturePath, $signatureData);
            $user->update(['signature' => $signaturePath]);

            return redirect()->route($routes['signature']['index'])
                ->with('success', 'Signature saved successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save signature: '.$e->getMessage());
        }
    }

    // Hapus signature
    public function deleteSignature()
    {
        try {
            $user = Auth::user();
            $routes = $this->getAllRoutes();
            
            if ($user->signature) {
                // Hapus file dari storage
                Storage::disk('public')->delete($user->signature);
                $user->update(['signature' => null]);
                
                return redirect()->route($routes['signature']['index'])
                    ->with('success', 'Signature deleted successfully!');
            }
            
            return redirect()->route($routes['signature']['index'])
                ->with('info', 'No signature to delete');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete signature: '.$e->getMessage());
        }
    }
}