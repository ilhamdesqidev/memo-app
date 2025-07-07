@extends('home')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Manajemen User</h2>

    <!-- Form Tambah User -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="text-xl font-semibold mb-4">Tambah User Baru</h3>
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1">Nama</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1">Role</label>
                    <select name="role" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Karyawan</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Tabel User -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-xl font-semibold mb-4">Daftar User</h3>
        <table class="w-full table-auto border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2 capitalize">{{ $user->role }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500">Edit</a>
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada data user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
