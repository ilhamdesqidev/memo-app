@extends('home')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Manajemen User</h2>

        

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
                        <a href="{{ route('admin.staff.edit', $user->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500">Edit</a>
                        <form action="{{ route('admin.staff.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
