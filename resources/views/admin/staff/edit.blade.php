@extends('home')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('admin.staff.index') }}" class="text-gray-600 hover:text-gray-800 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Edit Akun User</h2>
            </div>
            <p class="text-gray-600">Perbarui data user yang dipilih</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Informasi User</h3>
                <p class="text-sm text-gray-600 mt-1">Perbarui data user yang akan diubah</p>
            </div>

            <form method="POST" action="{{ route('admin.staff.update', $user->id) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-900 border-b border-gray-200 pb-2">Data Pribadi</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="md:col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('name') border-red-500 @enderror" 
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="Masukkan nama lengkap">
                            @error('name') 
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        <div class="md:col-span-1">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="username" 
                                id="username" 
                                required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('username') border-red-500 @enderror" 
                                value="{{ old('username', $user->username) }}"
                                placeholder="Masukkan username">
                            @error('username') 
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>

                    <!-- Jabatan -->
                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Jabatan
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="jabatan" 
                                id="jabatan" 
                                required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('jabatan') border-red-500 @enderror">
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="asisten" {{ old('jabatan', $user->jabatan) == 'asisten' ? 'selected' : '' }}>Asisten</option>
                            <option value="ketua" {{ old('jabatan', $user->jabatan) == 'ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="pengadaan" {{ old('jabatan', $user->jabatan) == 'pengadaan' ? 'selected' : '' }}>Pengadaan</option>
                        </select>
                        @error('jabatan') 
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label for="divisi_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Divisi
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="divisi_id" 
                                id="divisi_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('divisi_id') border-red-500 @enderror" 
                                required>
                            <option value="">-- Pilih Divisi --</option>
                            @foreach ($divisis as $divisi)
                                <option value="{{ $divisi->id }}" {{ old('divisi_id', $user->divisi_id) == $divisi->id ? 'selected' : '' }}>
                                    {{ $divisi->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('divisi_id') 
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p> 
                        @enderror
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="role"
                            id="role"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('role') border-red-500 @enderror">
                        <option value="">-- Pilih Role --</option>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="asisten_manager" {{ old('role', $user->role) == 'asisten_manager' ? 'selected' : '' }}>Asisten Manager</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Security Section -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-900 border-b border-gray-200 pb-2">Keamanan Akun</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div class="md:col-span-1">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('password') border-red-500 @enderror"
                                       placeholder="Kosongkan jika tidak diubah">
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        onclick="togglePassword('password')">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password') 
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="md:col-span-1">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                       placeholder="Kosongkan jika tidak diubah">
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        onclick="togglePassword('password_confirmation')">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.staff.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
}
</script>
@endsection