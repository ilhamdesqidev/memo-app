@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Memo Manager</h1>
    <p class="mb-6 text-gray-600">Selamat datang di halaman memo manager.</p>

    {{-- Tombol Buat Memo --}}
    <div class="mb-6">
        <a href="{{ route('manager.memo.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Buat Memo
        </a>
    </div>

    {{-- Tabel Memo --}}
    @if ($memos->isEmpty())
        <div class="bg-gray-100 p-4 rounded-lg text-center">
            <p class="text-gray-600">Belum ada memo.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($memos as $memo)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $memo->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $memo->creator->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('manager.memo.show', $memo->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 hover:underline">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if ($memos->hasPages())
            <div class="mt-4">
                {{ $memos->links() }}
            </div>
        @endif
    @endif
</div>
@endsection