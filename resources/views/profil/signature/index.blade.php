@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">Digital Signature</h2>
        </div>
        
        <div class="p-6">
            @if($user->signature)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Current Signature</h3>
                    <div class="border-2 border-gray-200 rounded-lg p-4 bg-white">
                        <img src="{{ asset('storage/' . $user->signature) }}" 
                             alt="Digital Signature" 
                             class="max-w-full h-auto max-h-32 mx-auto">
                    </div>
                    
                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route($baseRoute.'signature.create') }}" 
                           class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Update Signature
                        </a>
                        <form action="{{ route($baseRoute.'signature.delete') }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
                                    onclick="return confirm('Are you sure you want to delete your signature?')">
                                Delete Signature
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="mb-6">
                    <p class="text-gray-600 mb-4">You don't have a signature yet.</p>
                    <a href="{{ route($baseRoute.'signature.create') }}" 
                       class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Create Signature
                    </a>
                </div>
            @endif
            
            <div class="mt-4">
                <a href="{{ route($baseRoute.'index') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    Back to Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection