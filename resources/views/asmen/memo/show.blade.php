@extends('layouts.asisten_manager')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
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
        </div>

        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Nomor Memo</p>
                    <p class="font-medium">{{ $memo->nomor }}</p>
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

            @if($memo->status == 'diajukan')
            <div class="mt-6 border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Tindakan</h3>
                <div class="flex flex-wrap gap-3">
                <form action="{{ route('asmen.memo.approve', $memo->id) }}" method="POST" class="flex-1 min-w-[250px]">
                    @csrf
                    <div class="mb-3">
                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea name="catatan" id="catatan" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Tindakan Lanjutan</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="action_approve" name="next_action" value="approve" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="action_approve" class="ml-2 block text-sm text-gray-700">Setujui dan simpan</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="action_forward_manager" name="next_action" value="forward_manager" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="action_forward_manager" class="ml-2 block text-sm text-gray-700">Setujui dan teruskan ke Manager</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="action_forward_staff" name="next_action" value="forward_staff" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="action_forward_staff" class="ml-2 block text-sm text-gray-700">Setujui dan teruskan ke Staff</label>
                            </div>
                            
                            <div id="staffSelection" class="hidden ml-6 mt-2">
                                <label for="forward_to_staff_id" class="block text-sm font-medium text-gray-700">Pilih Staff</label>
                                <select name="forward_to_staff_id" id="forward_to_staff_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">-- Pilih Staff --</option>
                                    @foreach($staffList as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->divisi->nama }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center mb-3">
                        <input type="checkbox" name="include_signature" id="include_signature" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="include_signature" class="ml-2 block text-sm text-gray-700">Sertakan tanda tangan digital</label>
                    </div>
                    
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Proses Memo
                    </button>
                </form>

                    <form action="{{ route('asmen.memo.request-revision', $memo->id) }}" method="POST" class="flex-1 min-w-[250px]">
                        @csrf
                        <div class="mb-3">
                            <label for="catatan_revisi" class="block text-sm font-medium text-gray-700">
                                Catatan Revisi *
                            </label>
                            <textarea name="catatan_revisi" id="catatan_revisi" rows="3" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <button type="submit" 
                            class="w-full bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Minta Revisi
                        </button>
                    </form>

                    <form action="{{ route('asmen.memo.reject', $memo->id) }}" method="POST" class="flex-1 min-w-[250px]">
                        @csrf
                        <div class="mb-3">
                            <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan Penolakan *</label>
                            <textarea name="alasan" id="alasan" rows="3" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Tolak Memo
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <div class="mt-8 border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Riwayat Memo</h3>
                <div class="space-y-4">
                    @foreach($memo->logs as $log)
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-600 text-sm">{{ substr($log->user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate">{{ $log->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $log->aksi }} - {{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}</div>
                            <div class="mt-1 text-sm text-gray-700 break-words">{{ $log->catatan }}</div>
                        </div>
                    </div>
                    @endforeach
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
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-800 leading-relaxed break-words word-wrap" style="word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;">
                        {!! $memo->isi !!}
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

<style>
    /* Tambahkan style untuk memastikan konten tidak melebar */
    .container {
        max-width: 100%;
    }
    .prose {
        max-width: 100%;
        overflow-wrap: break-word;
    }
    textarea {
        max-width: 100%;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    const showMemoBtn = document.getElementById('showMemoContent');
    const modal = document.getElementById('memoContentModal');
    const closeModalTop = document.getElementById('closeMemoModal');
    const closeModalBottom = document.getElementById('closeMemoModalBottom');
    
    // Show modal
    showMemoBtn.addEventListener('click', function() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    });
    
    // Close modal functions
    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }
    
    closeModalTop.addEventListener('click', closeModal);
    closeModalBottom.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Staff selection functionality
    const staffSelection = document.getElementById('staffSelection');
    const staffRadios = document.querySelectorAll('input[name="next_action"]');
    
    staffRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'forward_staff') {
                staffSelection.classList.remove('hidden');
                document.getElementById('forward_to_staff_id').required = true;
            } else {
                staffSelection.classList.add('hidden');
                document.getElementById('forward_to_staff_id').required = false;
            }
        });
    });
});
</script>
@endsection