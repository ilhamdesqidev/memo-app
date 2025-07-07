<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tambah User</h2>
    </x-slot>

    <form action="{{ route('admin.users.store') }}" method="POST" class="max-w-md mx-auto mt-4">
        @csrf
        <div>
            <label>Nama</label>
            <input type="text" name="name" class="w-full border p-2" required>
        </div>

        <div class="mt-2">
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2" required>
        </div>

        <div class="mt-2">
            <label>Password</label>
            <input type="password" name="password" class="w-full border p-2" required>
        </div>

        <div class="mt-2">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border p-2" required>
        </div>

        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</x-app-layout>
