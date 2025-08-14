@extends('layouts.asisten')
@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Memo</h1>
                <p class="text-gray-600 mt-1">Nomor: {{ $memo->nomor }}</p>
            </div>
            <div class="flex space-x-2">
                @if(in_array(strtolower($memo->status), ['approved', 'disetujui']))
                <a href="{{ route('asisten.memo.pdf', $memo->id) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Memo Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Dari</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $memo->dari }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Kepada</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $memo->kepada }}</p>
            </div>
           <div>
                <h3 class="text-sm font-medium text-gray-500">Tanggal</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ \Carbon\Carbon::parse($memo->tanggal)->format('d F Y') }}
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <p class="mt-1">
                    @php
                        $statusConfig = [
                            'draft' => ['bg-gray-100 text-gray-700', 'Draft'],
                            'pending' => ['bg-yellow-100 text-yellow-700', 'Diajukan'],
                            'diajukan' => ['bg-yellow-100 text-yellow-700', 'Diajukan'],
                            'approved' => ['bg-green-100 text-green-700', 'Disetujui'],
                            'disetujui' => ['bg-green-100 text-green-700', 'Disetujui'],
                            'rejected' => ['bg-red-100 text-red-700', 'Ditolak'],
                            'ditolak' => ['bg-red-100 text-red-700', 'Ditolak'],
                            'revision' => ['bg-orange-100 text-orange-700', 'Revisi'],
                            'revisi' => ['bg-orange-100 text-orange-700', 'Revisi'],
                        ];
                        [$classes, $text] = $statusConfig[strtolower($memo->status)] ?? ['bg-gray-100 text-gray-700', ucfirst($memo->status)];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $classes }}">
                        {{ $text }}
                    </span>
                </p>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-sm font-medium text-gray-500">Perihal</h3>
            <p class="mt-1 text-sm text-gray-900">{{ $memo->perihal }}</p>
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-sm font-medium text-gray-500">Isi Memo</h3>
            <button onclick="toggleMemoContent()" class="mt-2 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Lihat Isi Memo
            </button>
        </div>

        @if($memo->lampiran)
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-sm font-medium text-gray-500">Lampiran</h3>
            <p class="mt-1 text-sm text-gray-900">{{ $memo->lampiran }} file terlampir</p>
        </div>
        @endif
    </div>

    <!-- Memo Content Modal -->
    <div id="memoContentModal" class="fixed inset-0 overflow-y-auto hidden z-50">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75" onclick="toggleMemoContent()"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Isi Memo
                            </h3>
                            <div class="mt-2 memo-content">
                                {!! $memo->isi !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="toggleMemoContent()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval History -->
    @if($memo->logs->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Riwayat Persetujuan</h2>
        <div class="space-y-4">
            @foreach($memo->logs as $log)
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</div>
                    <div class="text-sm text-gray-500">
                        {{ $log->aksi }} - {{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}
                    </div>
                    <div class="mt-1 text-sm text-gray-700">{{ $log->catatan }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
function toggleMemoContent() {
    const modal = document.getElementById('memoContentModal');
    modal.classList.toggle('hidden');
}
</script>

<style>
.memo-content {
    line-height: 1.6;
    max-height: 70vh;
    overflow-y: auto;
}

.memo-content p {
    margin-bottom: 1em;
    white-space: normal;
    word-wrap: break-word;
}

.memo-content ul, .memo-content ol {
    margin-left: 1.5em;
    margin-bottom: 1em;
}

.memo-content ul {
    list-style-type: disc;
}

.memo-content ol {
    list-style-type: decimal;
}

/* Modal transition */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

.transform {
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}
</style>
@endsection