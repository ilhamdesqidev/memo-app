@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('staff.memo.index') }}" 
                   class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors mr-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-xl font-semibold text-gray-800">Detail Memo</h2>
            </div>
            @php
                $statusClasses = [
                    'draft' => 'bg-gray-100 text-gray-800',
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                ];
                $statusText = [
                    'draft' => 'Draft',
                    'pending' => 'Menunggu Persetujuan',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ];
            @endphp
            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$memo->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusText[$memo->status] ?? ucfirst($memo->status) }}
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
                    <p class="font-medium">{{ $memo->tanggal->format('d F Y') }}</p>
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

            <!-- Signature -->
            @if($memo->signature)
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Tanda Tangan</h4>
                @if(file_exists(storage_path('app/public/'.$memo->signature)))
                    @if(Str::endsWith($memo->signature, '.pdf'))
                    <div class="border border-gray-200 rounded-lg p-4 overflow-x-auto bg-gray-50">
                        <embed src="{{ url('storage/'.$memo->signature) }}" 
                            type="application/pdf"
                            width="100%"
                            height="300px"
                            style="max-width: 100%">
                        <p class="text-center mt-3 text-sm text-gray-600">{{ $memo->dari }}</p>
                    </div>
                    @else
                    <div class="text-center p-4 border border-gray-200 rounded-lg max-w-xs mx-auto bg-gray-50">
                        <img src="{{ url('storage/'.$memo->signature) }}" 
                            alt="Tanda Tangan"
                            class="max-h-32 mx-auto mb-2 w-full h-auto">
                        <p class="text-sm text-gray-600">{{ $memo->dari }}</p>
                    </div>
                    @endif
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Memo -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Riwayat Persetujuan</h3>
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
                                            <span class="text-white text-sm font-medium">{{ substr($log->user->name ?? $log->divisi ?? 'U', 0, 1) }}</span>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $log->user->name ?? $log->divisi ?? 'Unknown' }}</p>
                                            <div class="mt-1">
                                                @if(str_contains(strtolower($log->aksi), 'approve') || str_contains(strtolower($log->aksi), 'setuju'))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ ucfirst($log->aksi) }}
                                                    </span>
                                                @elseif(str_contains(strtolower($log->aksi), 'reject') || str_contains(strtolower($log->aksi), 'tolak'))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ ucfirst($log->aksi) }}
                                                    </span>
                                                @elseif(str_contains(strtolower($log->aksi), 'revisi'))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ ucfirst($log->aksi) }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ ucfirst($log->aksi) }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($log->catatan || $log->rejection_reason)
                                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 border-l-4 border-gray-300 pl-3 py-2 pr-4 rounded-r">
                                                <span class="block text-gray-500 text-xs mb-1 font-medium">Catatan:</span>
                                                {{ $log->catatan ?? $log->rejection_reason }}
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
                    <p class="mt-1 text-sm text-gray-500">Belum ada aktivitas persetujuan pada memo ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    @if(auth()->user()->divisi->nama === $memo->divisi_tujuan && $memo->status === 'pending')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-6 bg-gray-50">
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                <form method="POST" action="{{ route('sipil.memo.approve', $memo->id) }}" class="flex-1">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        Setujui
                    </button>
                </form>
                <button onclick="openRejectModal({{ $memo->id }})" class="flex-1 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    Tolak
                </button>
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
                <div class="text-gray-700 leading-relaxed break-words memo-content">
                    {!! $memo->isi !!}
                </div>
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

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Alasan Penolakan</h3>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PUT')
            <textarea 
                name="rejection_reason" 
                rows="3" 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none mb-4" 
                placeholder="Masukkan alasan penolakan..."
                required></textarea>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-gray-700 text-sm font-medium hover:bg-gray-100 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom styles untuk konten rich text di modal */
.memo-content h1, .memo-content h2, .memo-content h3, 
.memo-content h4, .memo-content h5, .memo-content h6 {
    margin: 1rem 0 0.5rem 0;
    font-weight: 600;
    line-height: 1.25;
    color: #374151;
}

.memo-content h1 { font-size: 1.5rem; }
.memo-content h2 { font-size: 1.25rem; }
.memo-content h3 { font-size: 1.125rem; }
.memo-content h4 { font-size: 1rem; }
.memo-content h5 { font-size: 0.875rem; }
.memo-content h6 { font-size: 0.75rem; }

.memo-content p {
    margin: 0.75rem 0;
    text-align: justify;
    line-height: 1.6;
}

.memo-content strong {
    font-weight: 600;
}

.memo-content em {
    font-style: italic;
}

.memo-content u {
    text-decoration: underline;
}

.memo-content s {
    text-decoration: line-through;
}

.memo-content ul, .memo-content ol {
    margin: 0.75rem 0;
    padding-left: 1.5rem;
}

.memo-content li {
    margin: 0.25rem 0;
    line-height: 1.5;
}

.memo-content blockquote {
    margin: 1rem 0;
    padding: 0.75rem 1rem;
    border-left: 4px solid #e5e7eb;
    background-color: #f9fafb;
    font-style: italic;
    color: #6b7280;
}

.memo-content code {
    background-color: #f3f4f6;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    font-family: ui-monospace, SFMono-Regular, "Menlo", "Monaco", "Cascadia Code", "Segoe UI Mono", "Roboto Mono", "Oxygen Mono", "Ubuntu Monospace", "Source Code Pro", "Fira Code", "Droid Sans Mono", "Courier New", monospace;
    font-size: 0.875em;
    color: #dc2626;
}

.memo-content pre {
    background-color: #f3f4f6;
    padding: 1rem;
    border-radius: 0.375rem;
    overflow-x: auto;
    margin: 1rem 0;
    border: 1px solid #e5e7eb;
}

.memo-content pre code {
    background: none;
    padding: 0;
    color: inherit;
    font-size: inherit;
}

.memo-content a {
    color: #2563eb;
    text-decoration: underline;
}

.memo-content a:hover {
    color: #1d4ed8;
}

.memo-content img {
    max-width: 100%;
    height: auto;
    margin: 0.75rem 0;
    border-radius: 0.375rem;
}

/* Styling untuk align text */
.memo-content .ql-align-center {
    text-align: center;
}

.memo-content .ql-align-right {
    text-align: right;
}

.memo-content .ql-align-justify {
    text-align: justify;
}

/* Color styling */
.memo-content .ql-color-red {
    color: #dc2626;
}

.memo-content .ql-color-blue {
    color: #2563eb;
}

.memo-content .ql-color-green {
    color: #16a34a;
}

/* Background color styling */
.memo-content .ql-bg-yellow {
    background-color: #fef3c7;
}

.memo-content .ql-bg-red {
    background-color: #fecaca;
}

.memo-content .ql-bg-blue {
    background-color: #dbeafe;
}

/* Font size styling */
.memo-content .ql-size-small {
    font-size: 0.75em;
}

.memo-content .ql-size-large {
    font-size: 1.25em;
}

.memo-content .ql-size-huge {
    font-size: 1.5em;
}
</style>

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

function openRejectModal(memoId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/sipil/memo/${memoId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

function regeneratePdf(memoId) {
    if (confirm('Anda yakin ingin membuat ulang PDF?')) {
        fetch(`/sipil/memo/${memoId}/regenerate-pdf`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('PDF berhasil dibuat ulang');
                window.location.reload();
            } else {
                alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membuat PDF');
        });
    }
}
</script>
@endsection