@extends('layouts.divisi')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Memo Keluar</h1>
        <p class="text-gray-600 mt-2">Kelola memo yang telah Anda kirim (memo yang belum disetujui)</p>
    </div>
    
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('staff.memo.inbox') }}" 
               class="flex items-center px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                Kotak Masuk
            </a>

            <a href="{{ route('staff.arsip.index') }}" 
               class="flex items-center px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                Lihat Arsip
            </a>
            
            <select class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white shadow-sm" onchange="filterByStatus(this.value)">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        
        <a href="{{ route('staff.memo.create') }}" 
           class="flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Memo Baru
        </a>
    </div>

    <!-- Content -->
    @if ($memos->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada memo keluar</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Mulai dengan membuat memo baru untuk mengirim komunikasi ke divisi lain.</p>
            <a href="{{ route('staff.memo.create') }}" 
               class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Memo Pertama
            </a>
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
                                Tanggal
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
                                        @php
                                            // Define status dot colors
                                            $dotColors = [
                                                'ditolak' => 'bg-red-500',       // Merah - ditolak
                                                'diajukan' => 'bg-yellow-500',   // Kuning - diajukan
                                                'revisi' => 'bg-orange-500',     // Oren - revisi
                                                'draft' => 'bg-gray-400',        // Abu - draft
                                            ];
                                            $dotColor = $dotColors[strtolower($memo->status)] ?? 'bg-gray-400';
                                        @endphp
                                        <div class="w-2.5 h-2.5 rounded-full {{ $dotColor }} mr-3 shadow-sm"></div>
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
                                    @php
                                        $statusConfig = [
                                            'draft' => ['bg-gray-100 text-gray-700', 'Draft'],
                                            'diajukan' => ['bg-yellow-100 text-yellow-700', 'Diajukan'],
                                            'ditolak' => ['bg-red-100 text-red-700', 'Ditolak'],
                                            'revisi' => ['bg-orange-100 text-orange-700', 'Revisi'],
                                        ];
                                        [$classes, $text] = $statusConfig[strtolower($memo->status)] ?? ['bg-gray-100 text-gray-700', ucfirst($memo->status)];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-full {{ $classes }} shadow-sm">
                                        {{ $text }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium">{{ $memo->tanggal->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $memo->created_at->diffForHumans() }}</div>
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
                                        
                                        <!-- PDF Button - Hanya untuk memo disetujui (tidak akan muncul di sini) -->
                                        <span class="p-2.5 text-gray-300 cursor-not-allowed rounded-xl" title="PDF tersedia hanya untuk memo yang disetujui (lihat di Arsip)">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </span>
                                        
                                        <!-- Edit Button - Hanya untuk memo revisi -->
                                        @if($memo->status === 'revisi')
                                            <a href="{{ route('staff.memo.edit', $memo->id) }}" 
                                            class="p-2.5 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl transition-all duration-200"
                                            title="Revisi Memo">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        <!-- DELETE BUTTON - Tampil untuk semua memo yang belum disetujui -->
                                        <!-- Hapus kondisi @if($memo->status == 'draft') agar tombol delete selalu muncul -->
                                        <form action="{{ route('staff.memo.destroy', $memo->id) }}" 
                                              method="POST" 
                                              class="inline delete-form"
                                              data-id="{{ $memo->id }}"
                                              data-nomor="{{ $memo->nomor }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    onclick="confirmDelete({{ $memo->id }}, '{{ $memo->nomor }}', '{{ $memo->status }}')"
                                                    class="p-2.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-all duration-200"
                                                    title="Hapus Memo">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

function confirmDelete(memoId, memoNumber, memoStatus) {
    // Pesan berbeda berdasarkan status memo
    let statusMessage = '';
    switch(memoStatus) {
        case 'draft':
            statusMessage = 'Status: <span class="text-gray-600 font-semibold">Draft</span>';
            break;
        case 'diajukan':
            statusMessage = 'Status: <span class="text-yellow-600 font-semibold">Diajukan</span>';
            break;
        case 'revisi':
            statusMessage = 'Status: <span class="text-orange-600 font-semibold">Revisi</span>';
            break;
        case 'ditolak':
            statusMessage = 'Status: <span class="text-red-600 font-semibold">Ditolak</span>';
            break;
        default:
            statusMessage = '';
    }
    
    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Apakah Anda yakin ingin menghapus memo?<br><br>
               <div class="text-left">
                 <div><strong>Nomor:</strong> ${memoNumber}</div>
                 <div>${statusMessage}</div>
               </div><br>
               <span class="text-red-600 font-semibold">⚠️ PERINGATAN: Tindakan ini tidak dapat dibatalkan!</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus Sekarang!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-4 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500',
            cancelButton: 'px-4 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading state
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            
            // Cari form yang sesuai dengan memo ID
            const form = document.querySelector(`form.delete-form[data-id="${memoId}"]`);
            if (form) {
                form.submit();
            }
        }
    });
}
</script>
@endpush
@endsection