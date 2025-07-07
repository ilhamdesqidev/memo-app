@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto">
        <h2 class="text-xl font-semibold mb-4">Tambah Akun Staff</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.staff.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" required class="w-full border rounded p-2" value="{{ old('name') }}">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required class="w-full border rounded p-2" value="{{ old('email') }}">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required class="w-full border rounded p-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full border rounded p-2">
            </div>

            <div>
                <label for="jabatan_id">Jabatan</label>
                <select name="jabatan_id" id="jabatan_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                    @endforeach
                </select>
                @error('jabatan_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
