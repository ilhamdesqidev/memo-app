@extends('layouts.divisi')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-2">Daftar Memo Marketing</h1>
    <p class="mb-4">Selamat datang di halaman memo marketing.</p>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol Buat Memo --}}
    <div class="mb-4">
        <a href="{{ route('marketing.memo.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            + Buat Memo
        </a>
    </div>

    {{-- Tabel Memo --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Nomor</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Kepada</th>
                    <th class="px-4 py-2 border">Dari</th>
                    <th class="px-4 py-2 border">Perihal</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($memos as $memo)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $memo->nomor }}</td>
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($memo->tanggal)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 border">{{ $memo->kepada }}</td>
                        <td class="px-4 py-2 border">{{ $memo->dari }}</td>
                        <td class="px-4 py-2 border">{{ $memo->perihal }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('marketing.memo.show', $memo->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Belum ada memo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
