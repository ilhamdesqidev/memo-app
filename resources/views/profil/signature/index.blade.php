@extends(
    auth()->user()->role === 'manager' ? 'main' : 
    (auth()->user()->role === 'asisten_manager' ? 'layouts.asisten_manager' : 'layouts.divisi')
)

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-light text-gray-800 mb-2">Digital Signature</h1>
            <p class="text-gray-600">Manage your digital signature</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h2 class="text-xl font-medium text-white">Signature Management</h2>
            </div>

            <div class="p-8">
                @if($user->signature)
                    <!-- Current Signature -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            <h3 class="text-lg font-medium text-gray-800">Current Signature</h3>
                        </div>
                        
                        <!-- Signature Display -->
                        <div class="bg-gray-50 rounded-xl p-8 mb-6 text-center border border-gray-200">
                            <img src="{{ asset('storage/' . $user->signature) }}"
                                 alt="Digital Signature"
                                 class="max-w-full h-auto max-h-32 mx-auto">
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route($routes['signature']['create']) }}"
                               class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Update Signature
                            </a>
                            
                            <form action="{{ route($routes['signature']['delete']) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                                        onclick="return confirm('Are you sure you want to delete your signature?')">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Signature
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- No Signature -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-lg font-medium text-gray-800 mb-2">No signature found</h3>
                        <p class="text-gray-600 mb-6">You haven't created a digital signature yet.</p>
                        
                        <a href="{{ route($routes['signature']['create']) }}"
                           class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Signature
                        </a>
                    </div>
                @endif

                <!-- Back Button -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('profil.index') }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h4 class="font-medium text-gray-800 mb-1">Secure</h4>
                <p class="text-sm text-gray-600">Encrypted and protected</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h4 class="font-medium text-gray-800 mb-1">Fast</h4>
                <p class="text-sm text-gray-600">Quick application</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h4 class="font-medium text-gray-800 mb-1">Legal</h4>
                <p class="text-sm text-gray-600">Legally binding</p>
            </div>
        </div>
    </div>
</div>
@endsection