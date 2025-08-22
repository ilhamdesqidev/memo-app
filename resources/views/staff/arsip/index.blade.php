@extends('layouts.divisi')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Arsip Memo</h1>
        <p class="text-gray-600 mt-2">Daftar memo yang telah disetujui</p>
    </div>
    
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('staff.memo.index') }}" 
               class="flex items-center px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Semua Memo
            </a>
        </div>

        <div class="flex items-center gap-3">
            <select class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white shadow-sm" onchange="filterByStatus(this.value)">
                <option value="">Semua Status</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            </select>
        </div>
    </div>

    <!-- Content -->
    @if ($memos->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada memo yang disetujui</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Memo yang telah disetujui akan muncul di halaman arsip ini.</p>
        </div>
    @else
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
                                Kepada
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Perihal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal Disetujui
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($memos as $memo)
                            <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-2.5 h-2.5 rounded-full bg-green-500 mr-3 shadow-sm"></div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $memo->nomor }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center mr-3 shadow-sm">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $memo->divisi_tujuan }}</div>
                                            <div class="text-sm text-gray-500">{{ $memo->kepada }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-medium text-gray-900 mb-1">{{ Str::limit($memo->perihal, 50) }}</div>
                                    @if($memo->lampiran)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <span class="text-xs text-blue-600 font-medium">{{ $memo->lampiran }} lampiran</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-full bg-green-100 text-green-700 shadow-sm">
                                        Disetujui
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            @if($memo->approval_date)
                                                <div class="font-medium">{{ \Carbon\Carbon::parse($memo->approval_date)->format('d/m/Y') }}</div>
                                                <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($memo->approval_date)->diffForHumans() }}</div>
                                            @else
                                                <div class="font-medium">{{ $memo->updated_at->format('d/m/Y') }}</div>
                                                <div class="text-xs text-gray-400">{{ $memo->updated_at->diffForHumans() }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-1">
                                        <!-- View Button -->
                                        <a href="{{ route('staff.memo.show', $memo->id) }}" 
                                           class="p-2.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-xl transition-all duration-200"
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- PDF Button -->
                                        <a href="{{ route('staff.memo.pdf', $memo->id) }}" 
                                            target="_blank"
                                            class="p-2.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-xl transition-all duration-200"
                                            title="Download PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>

                                        <!-- PDF Viewer Button -->
                                        <button onclick="showPdfModal('{{ route('staff.memo.pdf', $memo->id) }}')"
                                            class="p-2.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-xl transition-all duration-200"
                                            title="Lihat PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($memos->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
                <div class="text-sm text-gray-600 font-medium">
                    Menampilkan {{ $memos->firstItem() }} sampai {{ $memos->lastItem() }} dari {{ $memos->total() }} memo
                </div>
                <div class="pagination-wrapper">
                    {{ $memos->links() }}
                </div>
            </div>
        @endif
    @endif
</div>

<!-- PDF Modal -->
<div id="pdfModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl w-11/12 h-5/6 max-w-6xl flex flex-col">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Preview PDF Memo</h3>
            <button onclick="closePdfModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1">
            <iframe id="pdfViewer" class="w-full h-full" frameborder="0"></iframe>
        </div>
    </div>
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

/* PDF Modal Styling */
#pdfModal {
    transition: opacity 0.3s ease;
}
</style>

<script>
function filterByStatus(status) {
    const url = new URL(window.location);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location = url;
}

function showPdfModal(pdfUrl) {
    document.getElementById('pdfViewer').src = pdfUrl;
    document.getElementById('pdfModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePdfModal() {
    document.getElementById('pdfModal').classList.add('hidden');
    document.getElementById('pdfViewer').src = '';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside content
document.getElementById('pdfModal').addEventListener('click', function(e) {
    if (e.target.id === 'pdfModal') {
        closePdfModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePdfModal();
    }
});
</script>

@endsection