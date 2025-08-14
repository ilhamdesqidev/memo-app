@extends('layouts.asisten')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Memo Divisi {{ $currentDivisi }}</h1>
            <p class="mt-1 text-sm text-gray-600">Memo internal divisi Anda</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Cari memo..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- Status Filter -->
    <div class="mb-6 flex space-x-2 overflow-x-auto pb-2">
        <a href="{{ route('asisten.memo.index') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('status') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Semua
        </a>
        <a href="{{ route('asisten.memo.index', ['status' => 'diajukan']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'diajukan' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Diajukan
        </a>
        <a href="{{ route('asisten.memo.index', ['status' => 'disetujui']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Disetujui
        </a>
        <a href="{{ route('asisten.memo.index', ['status' => 'ditolak']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Ditolak
        </a>
        <a href="{{ route('asisten.memo.index', ['status' => 'revisi']) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'revisi' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Revisi
        </a>
    </div>

    <!-- Memo Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dari</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerusan</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($memos as $memo)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- Nomor Memo -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $memo->nomor }}</div>
                                    <div class="text-xs text-gray-500">{{ $memo->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Dari -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $memo->dibuatOleh->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-gray-500">{{ $memo->dibuatOleh->position ?? 'Staff' }}</div>
                        </td>

                        <!-- Perihal -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($memo->perihal, 50) }}</div>
                            @if($memo->lampiran)
                            <div class="flex items-center mt-1 text-xs text-blue-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                {{ $memo->lampiran }} lampiran
                            </div>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'diajukan' => 'bg-yellow-100 text-yellow-800',
                                    'disetujui' => 'bg-green-100 text-green-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                    'revisi' => 'bg-orange-100 text-orange-800',
                                    'draft' => 'bg-gray-100 text-gray-800'
                                ];
                                $statusClass = $statusClasses[strtolower($memo->status)] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($memo->status) }}
                            </span>
                        </td>

                        <!-- Penerusan -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($memo->divisi_tujuan !== $currentDivisi)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-purple-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Diteruskan ke {{ $memo->divisi_tujuan }}
                            </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2">
                                <!-- View Button -->
                                <a href="{{ route('asisten.memo.show', $memo->id) }}" class="text-blue-600 hover:text-blue-900 p-1 rounded-md hover:bg-blue-50" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <!-- PDF Button (only for approved memos) -->
                               @if($memo->status === 'disetujui')
                                <a href="{{ route('asisten.memo.pdf', $memo->id) }}" 
                                target="_blank"
                                class="text-green-600 hover:text-green-900 p-1 rounded-md hover:bg-green-50" 
                                title="Lihat PDF">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-12">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada memo</h3>
                                <p class="mt-1 text-sm text-gray-500">Belum ada memo yang dibuat untuk divisi Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($memos->hasPages())
    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <div class="text-sm text-gray-700">
            Menampilkan <span class="font-medium">{{ $memos->firstItem() }}</span> sampai <span class="font-medium">{{ $memos->lastItem() }}</span> dari <span class="font-medium">{{ $memos->total() }}</span> memo
        </div>
        <div class="flex space-x-1">
            {{ $memos->links() }}
        </div>
    </div>
    @endif
</div>

<style>
    .pagination .page-item.active .page-link {
        @apply bg-blue-600 text-white border-blue-600;
    }
    .pagination .page-link {
        @apply px-3 py-1 border border-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-50;
    }
    .pagination .page-item.disabled .page-link {
        @apply text-gray-400 cursor-not-allowed hover:bg-white;
    }
</style>

<script>
    // Search functionality
    document.querySelector('input[type="text"]').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            const searchTerm = this.value.trim();
            if (searchTerm) {
                window.location.href = "{{ route('asisten.memo.index') }}?search=" + encodeURIComponent(searchTerm);
            }
        }
    });

    // Filter by status from URL
    const urlParams = new URLSearchParams(window.location.search);
    const statusParam = urlParams.get('status');
    if (statusParam) {
        document.querySelectorAll('.status-filter').forEach(filter => {
            filter.classList.remove('bg-blue-100', 'text-blue-800');
            if (filter.dataset.status === statusParam) {
                filter.classList.add('bg-blue-100', 'text-blue-800');
            }
        });
    }
</script>
@endsection