@extends('layouts.asisten_manager')

@section('title', 'Detail Memo - Asisten Manager')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Detail Memo</h2>
            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                @if($memo->status == 'diajukan') bg-yellow-100 text-yellow-800
                @elseif($memo->status == 'disetujui') bg-green-100 text-green-800
                @elseif($memo->status == 'ditolak') bg-red-100 text-red-800
                @elseif($memo->status == 'revisi') bg-blue-100 text-blue-800
                @endif">
                {{ ucfirst($memo->status) }}
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
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($memo->created_at)->format('d F Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dari</p>
                    <p class="font-medium">{{ $memo->dari }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kepada</p>
                    <p class="font-medium">{{ $memo->divisiTujuan->nama ?? '-' }}</p>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Perihal</p>
                <p class="font-medium">{{ $memo->perihal }}</p>
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
                <a href="{{ asset('storage/' . $memo->lampiran) }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 hover:bg-blue-100 transition">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828M7 7h.01"/>
                    </svg>
                    Lihat Lampiran
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Memo -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Riwayat Memo</h3>
        </div>
        <div class="px-6 py-4">
            @if($memo->logs && $memo->logs->count() > 0)
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($memo->logs as $index => $log)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <span class="text-white text-sm font-medium">{{ substr($log->user->name, 0, 1) }}</span>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $log->user->name }}</p>
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
                                                @elseif(str_contains(strtolower($log->aksi), 'revisi'))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
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
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada aktivitas pada memo ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- PDF Actions -->
    @if($memo->status == 'disetujui')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-6 text-center">
            <h5 class="text-lg font-medium text-gray-800 mb-2">Dokumen PDF</h5>
            <p class="text-gray-500 mb-4">Memo telah disetujui dan siap diunduh</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('asmen.memo.view-pdf', $memo->id) }}" target="_blank"
                   class="px-5 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                    Lihat PDF
                </a>
                <a href="{{ route('asmen.memo.pdf', $memo->id) }}"
                   class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Unduh PDF
                </a>
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
                <div class="text-gray-700 leading-relaxed break-words">{{ strip_tags($memo->isi) }}</div>
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
</script>
@endsection