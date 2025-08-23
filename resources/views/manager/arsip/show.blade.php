@extends('main')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('manager.arsip.index') }}" 
                   class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors mr-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-xl font-semibold text-gray-800">Detail Memo</h2>
            </div>
            @php
                $statusColor = $memo->status == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                $statusText = $memo->status == 'disetujui' ? 'Disetujui' : 'Ditolak';
            @endphp
            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                {{ $statusText }}
            </span>
        </div>

        <!-- Info Memo -->
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Nomor Memo</p>
                    <p class="font-medium">{{ $memo->nomor ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($memo->created_at)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dari</p>
                    <p class="font-medium">{{ $memo->dari }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kepada</p>
                    <p class="font-medium">{{ $memo->kepada }}</p>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Perihal</p>
                <p class="font-medium">{{ $memo->perihal }}</p>
            </div>

            <!-- Tanggal Selesai -->
            <div class="mb-4">
                <p class="text-sm text-gray-500">Tanggal Selesai</p>
                <p class="font-medium">
                    @if($memo->status == 'disetujui' && $memo->approval_date)
                        {{ \Carbon\Carbon::parse($memo->approval_date)->format('d F Y') }}
                    @elseif($memo->status == 'ditolak' && $memo->rejection_date)
                        {{ \Carbon\Carbon::parse($memo->rejection_date)->format('d F Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($memo->updated_at)->format('d F Y') }}
                    @endif
                </p>
            </div>

            <!-- Isi Memo Button -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Isi Memo</h4>
                <button onclick="openMemoModal()" 
                        class="inline-flex items-center px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition-colors duration-200 w-full text-left">
                    <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-800">Klik untuk melihat isi memo</p>
                        <p class="text-sm text-gray-500">Klik tombol ini untuk membaca isi memo lengkap</p>
                    </div>
                </button>
            </div>

            <!-- Lampiran -->
            @if($memo->lampiran)
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Lampiran</h4>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <span class="text-sm text-gray-600">{{ $memo->lampiran }}</span>
                </div>
            </div>
            @endif


            <!-- Status Info -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Status Informasi</h4>
                <div class="space-y-2">
                    @if($memo->status == 'disetujui')
                        <div class="flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Disetujui oleh: {{ $memo->disetujuiOleh->name ?? 'Manager' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Pada: {{ \Carbon\Carbon::parse($memo->approval_date)->format('d F Y H:i') }}</span>
                        </div>
                    @elseif($memo->status == 'ditolak')
                        <div class="flex items-center text-red-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Ditolak oleh: {{ $memo->ditolakOleh->name ?? 'Manager' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Pada: {{ \Carbon\Carbon::parse($memo->rejection_date)->format('d F Y H:i') }}</span>
                        </div>
                        @if($memo->alasan_penolakan)
                        <div class="mt-2">
                            <h5 class="text-sm font-medium text-gray-500">Alasan Penolakan:</h5>
                            <p class="text-red-600 text-sm">{{ $memo->alasan_penolakan }}</p>
                        </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('manager.arsip.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Arsip
                </a>
                @if($memo->status == 'disetujui')
                <a href="{{ route('manager.arsip.pdf', $memo->id) }}" target="_blank" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                    </svg>
                    Lihat PDF
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Riwayat Log -->
    @if($memo->logs && $memo->logs->count() > 0)
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Riwayat Aktivitas</h3>
        </div>
        <div class="px-6 py-4">
            <div class="flow-root">
                <ul class="-mb-8">
                    @foreach($memo->logs->sortBy('waktu') as $index => $log)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                        <span class="text-white text-sm font-medium">{{ substr($log->user->name ?? 'S', 0, 1) }}</span>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'Sistem' }}</p>
                                        <p class="text-xs text-gray-500">{{ $log->divisi }}</p>
                                        <div class="mt-1">
                                            @if(str_contains(strtolower($log->aksi), 'setuju'))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $log->aksi }}
                                                </span>
                                            @elseif(str_contains(strtolower($log->aksi), 'tolak'))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $log->aksi }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $log->aksi }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($log->catatan)
                                        <div class="mt-2 text-sm text-gray-600 bg-gray-50 border-l-4 border-gray-300 pl-3 py-2 pr-4 rounded-r">
                                            <span class="block text-gray-500 text-xs mb-1 font-medium">Catatan:</span>
                                            {{ $log->catatan }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="{{ $log->waktu }}">{{ \Carbon\Carbon::parse($log->waktu)->format('d M Y') }}</time>
                                        <br>
                                        <time datetime="{{ $log->waktu }}">{{ \Carbon\Carbon::parse($log->waktu)->format('H:i') }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal untuk Isi Memo -->
<div id="memoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Isi Memo</h3>
                <button onclick="closeMemoModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="max-h-96 overflow-y-auto">
                <div id="memoContent" class="text-gray-700 leading-relaxed break-words whitespace-pre-line">{{ $memo->isi }}</div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end pt-4 mt-4 border-t border-gray-200">
                <button onclick="closeMemoModal()" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openMemoModal() {
    // Bersihkan tag HTML dari isi memo sebelum menampilkan
    const memoContent = document.getElementById('memoContent');
    memoContent.innerHTML = memoContent.textContent.replace(/<[^>]*>/g, '');
    
    document.getElementById('memoModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeMemoModal() {
    document.getElementById('memoModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('memoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMemoModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeMemoModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    console.log('Halaman detail memo dimuat');
});
</script>
@endsection

@section('scripts')
<!-- Tambahkan script khusus untuk halaman ini jika diperlukan -->
@endsection