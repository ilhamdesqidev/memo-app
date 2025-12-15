@extends('main')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Detail Memo - Manager</h2>
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    @if($memo->status == 'diajukan') bg-yellow-100 text-yellow-800
                    @elseif($memo->status == 'disetujui') bg-green-100 text-green-800
                    @elseif($memo->status == 'ditolak') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($memo->status) }}
                </span>
            </div>
        </div>

        <div class="px-6 py-4">
            <!-- Informasi dasar memo -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Nomor Memo</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $memo->nomor }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Tanggal</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        @if($memo->tanggal)
                            {{ $memo->tanggal->format('d F Y') }}
                        @else
                            {{ $memo->created_at->format('d F Y') }}
                        @endif
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Dari</h4>
                    <!-- PERBAIKAN: Gunakan optional chaining -->
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $memo->dibuatOleh?->name ?? $memo->dari }} 
                        @if($memo->divisiAsal?->nama)
                            ({{ $memo->divisiAsal->nama }})
                        @endif
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Perihal</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ $memo->perihal }}</p>
                </div>
            </div>

            <!-- Tombol untuk melihat isi memo -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Isi Memo</h4>
                <button type="button" id="showMemoContent" class="w-full px-4 py-3 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg text-left transition-colors duration-200 group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-blue-700 font-medium">Klik untuk melihat isi memo</span>
                        </div>
                        <svg class="h-5 w-5 text-blue-600 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </button>
            </div>

            <!-- Lampiran -->
            @if($memo->lampiran)
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500">Lampiran</h4>
                <div class="mt-2 flex items-center">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    @if(Str::startsWith($memo->lampiran, 'http'))
                        <a href="{{ $memo->lampiran }}" target="_blank" class="ml-2 text-sm text-blue-600 hover:text-blue-800">
                            Download Lampiran
                        </a>
                    @else
                        <a href="{{ asset('storage/' . $memo->lampiran) }}" target="_blank" class="ml-2 text-sm text-blue-600 hover:text-blue-800">
                            Download Lampiran
                        </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Bagian form persetujuan -->
            @if($canProcess)
            <div class="bg-gray-50 p-4 rounded-lg mt-6">
                <h3 class="text-lg font-medium mb-4">Penerusan Memo</h3>
                
                <form action="{{ route('manager.memo.approve', $memo->id) }}" method="POST" id="forwardForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Divisi Tujuan</label>
                        <select name="divisi_tujuan" required class="w-full border border-gray-300 rounded-md p-2" id="divisiSelect">
                            <option value="">Pilih Divisi Tujuan</option>
                            @foreach($otherDivisions as $division)
                                @php
                                    $asmen = $division->asistenManagers->first();
                                @endphp
                                @if($asmen)
                                    <option value="{{ $division->nama }}" 
                                        data-asmen="{{ $asmen->name }}">
                                        {{ $division->nama }} (Asmen: {{ $asmen->name }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Hanya divisi dengan Asisten Manager aktif yang ditampilkan</p>
                    </div>

                    <!-- Opsi Tanda Tangan -->
                    <div class="mb-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <input type="checkbox" id="include_signature" name="include_signature" value="1" 
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                       {{ auth()->user()->signature ? '' : 'disabled' }}>
                            </div>
                            <div class="flex-1">
                                <label for="include_signature" class="block text-sm font-medium text-gray-700">
                                    Sertakan Tanda Tangan Manager
                                    @if(auth()->user()->signature)
                                        <span class="text-green-600 text-xs">(✓ Tersedia)</span>
                                    @else
                                        <span class="text-red-600 text-xs">(Belum tersedia)</span>
                                    @endif
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if(auth()->user()->signature)
                                        Centang untuk menyertakan tanda tangan digital Anda pada dokumen PDF
                                    @else
                                        <span class="text-red-500">Anda belum memiliki tanda tangan digital. 
                                        <a href="{{ route('profil.signature.index') }}" target="_blank" class="text-blue-600 hover:underline">Buat tanda tangan</a>
                                        </span>
                                    @endif
                                </p>
                                
                                @if(auth()->user()->signature)
                                <div id="signaturePreview" class="mt-2 hidden">
                                    <p class="text-xs text-gray-600 mb-1">Preview tanda tangan:</p>
                                    <div class="border border-gray-200 rounded p-2 bg-white inline-block">
                                        <img src="{{ asset('storage/' . auth()->user()->signature) }}" 
                                             alt="Preview Tanda Tangan" 
                                             class="max-h-16 max-w-32 object-contain">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="catatan" rows="3" class="w-full border border-gray-300 rounded-md p-2" placeholder="Tambahkan catatan untuk penerusan memo ini..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('manager.memo.inbox') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-share mr-2"></i> Teruskan ke Asisten Manager
                        </button>
                    </div>
                </form>

                <!-- Form untuk menolak memo -->
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium mb-4">Penolakan Memo</h3>
                    
                    <form action="{{ route('manager.memo.reject', $memo->id) }}" method="POST" id="rejectForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="alasan" rows="3" required class="w-full border border-gray-300 rounded-md p-2" placeholder="Berikan alasan jelas mengapa memo ini ditolak"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Wajib diisi. Maksimal 500 karakter.</p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="history.back()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Kembali
                            </button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200">
                                <i class="fas fa-ban mr-2"></i> Tolak Memo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Riwayat memo -->
            <div class="mt-8 border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Riwayat Memo</h3>
                <div class="space-y-4">
                    @forelse($memo->logs as $log)
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                <!-- PERBAIKAN: Gunakan optional chaining -->
                                <span class="text-gray-600 text-sm">
                                    {{ $log->user?->name ? substr($log->user->name, 0, 1) : 'S' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <!-- PERBAIKAN: Gunakan optional chaining -->
                            <div class="text-sm font-medium text-gray-900 truncate">
                                {{ $log->user?->name ?? 'Sistem' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $log->aksi }} - {{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}
                            </div>
                            @if($log->catatan)
                            <div class="mt-1 text-sm text-gray-700 break-words">{{ $log->catatan }}</div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">
                        Belum ada riwayat untuk memo ini
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan isi memo -->
<div id="memoContentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Isi Memo</h3>
                <button type="button" id="closeMemoModal" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-1 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="px-6 py-4 overflow-y-auto flex-1">
                <div class="prose max-w-none">
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-800 leading-relaxed break-words" style="word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;">
                        {!! nl2br(e($memo->isi)) !!}
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" id="closeMemoModalBottom" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@if($canProcess)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    const showMemoBtn = document.getElementById('showMemoContent');
    const modal = document.getElementById('memoContentModal');
    const closeModalTop = document.getElementById('closeMemoModal');
    const closeModalBottom = document.getElementById('closeMemoModalBottom');
    
    if (showMemoBtn) {
        showMemoBtn.addEventListener('click', function() {
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    }
    
    // Close modal functions
    function closeModal() {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }
    
    if (closeModalTop) closeModalTop.addEventListener('click', closeModal);
    if (closeModalBottom) closeModalBottom.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Signature preview functionality
    const signatureCheckbox = document.getElementById('include_signature');
    const signaturePreview = document.getElementById('signaturePreview');
    
    if (signatureCheckbox && signaturePreview) {
        signatureCheckbox.addEventListener('change', function() {
            if (this.checked) {
                signaturePreview.classList.remove('hidden');
            } else {
                signaturePreview.classList.add('hidden');
            }
        });
    }

    // Validasi form penerusan
    const divisiSelect = document.getElementById('divisiSelect');
    const forwardForm = document.getElementById('forwardForm');
    
    if (forwardForm) {
        forwardForm.addEventListener('submit', function(e) {
            if (!divisiSelect || !divisiSelect.value) {
                e.preventDefault();
                alert('Silakan pilih divisi tujuan terlebih dahulu');
                return false;
            }

            // Konfirmasi penerusan dengan/tanpa tanda tangan
            const includeSignature = signatureCheckbox && signatureCheckbox.checked;
            const confirmMessage = includeSignature 
                ? 'Apakah Anda yakin ingin meneruskan memo ini dengan tanda tangan digital Anda?'
                : 'Apakah Anda yakin ingin meneruskan memo ini?';
                
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        });
    }

    // Validasi form penolakan
    const rejectForm = document.getElementById('rejectForm');
    
    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            const alasan = rejectForm.querySelector('textarea[name="alasan"]');
            
            if (!alasan || !alasan.value.trim()) {
                e.preventDefault();
                alert('Silakan berikan alasan penolakan');
                return false;
            }
            
            if (alasan.value.trim().length > 500) {
                e.preventDefault();
                alert('Alasan penolakan maksimal 500 karakter');
                return false;
            }
            
            if (!confirm('Apakah Anda yakin ingin menolak memo ini?')) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>
@endpush
@else
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality (untuk user yang tidak bisa memproses)
    const showMemoBtn = document.getElementById('showMemoContent');
    const modal = document.getElementById('memoContentModal');
    const closeModalTop = document.getElementById('closeMemoModal');
    const closeModalBottom = document.getElementById('closeMemoModalBottom');
    
    if (showMemoBtn) {
        showMemoBtn.addEventListener('click', function() {
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    }
    
    // Close modal functions
    function closeModal() {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }
    
    if (closeModalTop) closeModalTop.addEventListener('click', closeModal);
    if (closeModalBottom) closeModalBottom.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endpush
@endif
@endsection