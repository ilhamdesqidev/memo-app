@extends('main') <!-- Sesuaikan dengan layout utama Anda -->

@section('content')

<!-- Tambahkan di bagian atas form -->
<div class="mb-4">
    <a href="{{ route('profile.index') }}" class="text-indigo-600 hover:text-indigo-800">
        &larr; Back to Profile
    </a>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <h2 class="text-xl font-semibold text-white">Profile Information</h2>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profil.update') }}">
                @csrf
                @method('patch')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="username" type="username" name="username" value="{{ old('username', $user->username) }}" required>
                    @error('username')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection