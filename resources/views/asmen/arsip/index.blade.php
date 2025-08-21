@extends('main')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Arsip Memo</h1>
        <p class="text-gray-600 mt-2">Daftar memo yang telah diarsipkan</p>
    </div>

    <!-- Content -->
    @forelse ($memos as $memo)
        @if($loop->first)
            <!-- Table Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Nomor Memo
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Perihal
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
        @endif
                            <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-2.5 h-2.5 rounded-full bg-blue-500 mr-3 shadow-sm"></div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $memo->nomor }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center mr-3 shadow-sm">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 mb-1">{{ $memo->perihal ?? 'Tidak ada perihal' }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($memo->perihal ?? 'Tidak ada perihal', 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusColors = [
                                            'aktif' => 'bg-green-100 text-green-700',
                                            'selesai' => 'bg-blue-100 text-blue-700',
                                            'disetujui' => 'bg-blue-100 text-blue-700',
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'ditolak' => 'bg-red-100 text-red-700',
                                            'draft' => 'bg-gray-100 text-gray-700'
                                        ];
                                        $colorClass = $statusColors[strtolower($memo->status)] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-full {{ $colorClass }} shadow-sm capitalize">
                                        {{ $memo->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-1">
                                        <!-- PDF Button -->
                                        <a href="{{ route('asmen.arsip.pdf', $memo) }}" 
                                            target="_blank"
                                            class="p-2.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-xl transition-all duration-200"
                                            title="Download PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
        @if($loop->last)
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada arsip memo</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Arsip memo akan muncul di halaman ini setelah memo diproses.</p>
        </div>
    @endforelse

    <!-- Pagination -->
    @if(method_exists($memos, 'hasPages') && $memos->hasPages())
        <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
            <div class="text-sm text-gray-600 font-medium">
                Menampilkan {{ $memos->firstItem() }} sampai {{ $memos->lastItem() }} dari {{ $memos->total() }} memo
            </div>
            <div class="pagination-wrapper">
                {{ $memos->links() }}
            </div>
        </div>
    @endif
</div>

<style>
/* Custom Pagination Styling */
.pagination-wrapper .pagination {
    display: flex;
    gap: 0.25rem;
}

.pagination-wrapper .page-link {
    @apply px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200;
}

.pagination-wrapper .page-item.active .page-link {
    @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700;
}

.pagination-wrapper .page-item.disabled .page-link {
    @apply text-gray-300 cursor-not-allowed hover:bg-white hover:text-gray-300;
}
</style>
@endsection