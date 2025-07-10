@extends('home')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">My Profile</h2>
        </div>
        
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="user-avatar text-2xl">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-600">{{ Auth::user()->username }}</p>
                    @if(Auth::user()->divisi)
                        <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full">
                            {{ Auth::user()->divisi->nama }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700 mb-2">Personal Information</h4>
                    <p><span class="font-medium">Name:</span> {{ Auth::user()->name }}</p>
                    <p><span class="font-medium">username:</span> {{ Auth::user()->username }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700 mb-2">Account Actions</h4>
                    <div class="space-y-2">
                        <a href="{{ route('profile.edit') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Edit Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection