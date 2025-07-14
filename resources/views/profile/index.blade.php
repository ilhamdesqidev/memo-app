@extends('home')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">My Profile</h1>
                <p class="text-gray-600">Manage your personal information and account settings</p>
            </div>

            <!-- Main Profile Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <!-- Cover Section -->
                <div class= "bg-indigo-600 h-32 relative">
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="flex items-end">
                            <!-- Avatar -->
                            <div class="relative">
                                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-slate-700 shadow-lg border-4 border-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white"></div>
                            </div>
                            
                            <!-- User Info -->
                            <div class="ml-6 pb-2">
                                <h2 class="text-2xl font-bold text-white mb-1">{{ Auth::user()->name }}</h2>
                                <p class="text-gray-200">{{ Auth::user()->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="p-8">
                    <!-- Division Badge -->
                    @if(Auth::user()->divisi)
                        <div class="mb-6">
                            <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ Auth::user()->divisi->nama }}
                            </span>
                        </div>
                    @endif

                    <!-- Information Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                                    <span class="text-gray-600 font-medium">Full Name</span>
                                    <span class="text-gray-800 font-semibold">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                                    <span class="text-gray-600 font-medium">Username</span>
                                    <span class="text-gray-800 font-semibold">{{ Auth::user()->username }}</span>
                                </div>
                                @if(Auth::user()->divisi)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 font-medium">Division</span>
                                    <span class="text-gray-800 font-semibold">{{ Auth::user()->divisi->nama }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Account Actions -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">Account Actions</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <a href="{{ route('profile.edit') }}" class="flex items-center justify-center w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-slate-800 transition-colors duration-200 shadow-sm">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                    Edit Profile
                                </a>
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-center w-full px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 shadow-sm">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Member Since</p>
                            <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Account Status</p>
                            <p class="text-lg font-semibold text-green-600">Active</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-slate-50 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Profile</p>
                            <p class="text-lg font-semibold text-slate-600">Complete</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection