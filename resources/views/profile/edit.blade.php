@extends('home')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('profile.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 rounded-lg hover:bg-indigo-50 transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                    Back to Profile
                </a>
            </div>

            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Profile</h1>
                <p class="text-gray-600">Update your personal information and account settings</p>
            </div>

            <!-- Edit Form Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-indigo-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Profile Information</h2>
                            <p class="text-indigo-100">Make changes to your account information</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-green-700 font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Current User Info Display -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl mb-8 border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Current Information</h3>
                                <p class="text-gray-600">{{ Auth::user()->name }} ({{ Auth::user()->username }})</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="name">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    Full Name
                                </span>
                            </label>
                            <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md" 
                                   id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   placeholder="Enter your full name">
                            @error('name')
                                <div class="flex items-center mt-2 text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Username Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700" for="username">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                                    </svg>
                                    Username
                                </span>
                            </label>
                            <input class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md" 
                                   id="username" 
                                   type="text" 
                                   name="username" 
                                   value="{{ old('username', $user->username) }}" 
                                   required
                                   placeholder="Enter your username">
                            @error('username')
                                <div class="flex items-center mt-2 text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit" class="flex-1 flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-indigo-300 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Save Changes
                            </button>
                            
                            <a href="{{ route('profile.index') }}" class="flex-1 flex items-center justify-center px-6 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-50 border border-gray-300 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Need Help?</h3>
                </div>
                <div class="text-gray-600 space-y-2">
                    <p>• Make sure your username is unique and easy to remember</p>
                    <p>• Your full name will be displayed on your profile</p>
                    <p>• Changes will be saved immediately after clicking "Save Changes"</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection