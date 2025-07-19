@extends('layouts.divisi')

@section('content')
<div class="container">
    <h1>Memo Marketing</h1>
    <p>Selamat datang di halaman memo marketing.</p>

    {{-- Tombol Buat Memo --}}
    <div class="mb-4">
        <a href="{{ route('marketing.memo.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Buat Memo
        </a>
    </div>

    {{-- Tabel Memo --}}
    <table class="table-auto w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Judul</th>
                <th class="px-4 py-2 border">Dibuat oleh</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($memos as $memo)
                <tr class="border-t">
                    <td class="px-4 py-2 border">{{ $memo->judul }}</td>
                    <td class="px-4 py-2 border">{{ $memo->creator->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('marketing.memo.show', $memo->id) }}" class="text-blue-600 hover:underline">
                            Lihat
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4">Belum ada memo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
