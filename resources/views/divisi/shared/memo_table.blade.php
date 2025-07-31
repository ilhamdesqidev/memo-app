@extends('layouts.divisi')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Memo Masuk - {{ $currentDivisi }}</h1>
    </div>

    <div class="mb-4">
        <a href="{{ route($routePrefix . '.memo.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Memo Keluar
        </a>
    </div>

    @if ($memos->isEmpty())
        <div class="bg-gray-50 border rounded-lg p-8 text-center">
            <p class="text-gray-600">Tidak ada memo masuk.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dari/Kepada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($memos as $memo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $memo->nomor }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="text-green-600">Dari: {{ $memo->dari }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $memo->perihal }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $memo->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                   $statusConfig = [
                                        'draft' => ['bg-gray-100 text-gray-700', 'Draft'],
                                        'diajukan' => ['bg-yellow-100 text-yellow-700', 'Diajukan'],
                                        'disetujui' => ['bg-green-100 text-green-700', 'Disetujui'],
                                        'ditolak' => ['bg-red-100 text-red-700', 'Ditolak'],
                                        'revisi' => ['bg-orange-100 text-orange-700', 'Revisi'],
                                    ];
                                    [$classes, $text] = $statusConfig[strtolower($memo->status)] ?? ['bg-gray-100 text-gray-700', ucfirst($memo->status)];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
                                    {{ $text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route($routePrefix . '.memo.show', $memo->id) }}" 
                                   class="text-blue-600 hover:text-blue-800">Detail</a>
                                <button onclick="openModal('approve', {{ $memo->id }})" 
                                        class="text-green-600 hover:text-green-800">Setujui</button>
                                <button onclick="openModal('reject', {{ $memo->id }})" 
                                        class="text-red-600 hover:text-red-800">Tolak</button>
                                <button onclick="openModal('revisi', {{ $memo->id }})" 
                                        class="text-yellow-600 hover:text-yellow-800">Revisi</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $memos->links() }}
        </div>

               <!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Proses Memo</h3>
            <form method="POST" action="{{ route($routePrefix . '.memo.updateStatus') }}">
                @csrf
                <input type="hidden" name="memo_id" id="approveMemoId">
                <input type="hidden" name="action" value="setujui">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan:</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="finalApprove" name="approval_type" value="final" class="h-4 w-4 text-green-600 focus:ring-green-500" checked>
                            <label for="finalApprove" class="ml-2 block text-sm text-gray-700">
                                Setujui secara final
                                <p class="text-xs text-gray-500">Memo akan disetujui dan selesai diproses</p>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="forwardApprove" name="approval_type" value="forward" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <label for="forwardApprove" class="ml-2 block text-sm text-gray-700">
                                Teruskan ke divisi lain
                                <p class="text-xs text-gray-500">Memo akan tetap berstatus diajukan</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4 hidden" id="divisiTujuanContainer">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Divisi Tujuan:</label>
                    <select name="next_divisi" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Divisi --</option>
                        @foreach($divisiTujuan as $div)
                            <option value="{{ $div->nama }}">{{ $div->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Signature option -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="include_signature" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2">Sertakan tanda tangan saya</span>
                    </label>
                    @if(auth()->user()->signature)
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                Tanda tangan tersedia
                            </span>
                        </div>
                    @else
                        <div class="mt-2 text-sm text-red-500">
                            Anda belum mengunggah tanda tangan.
                        </div>
                    @endif
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        Proses
                    </button>
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Show/hide division selection based on radio button
    document.querySelectorAll('input[name="approval_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const divisiContainer = document.getElementById('divisiTujuanContainer');
            divisiContainer.classList.toggle('hidden', this.value !== 'forward');
        });
    });
</script>

        <!-- Modal Tolak -->
        <div id="rejectModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tolak Memo</h3>
                    <form method="POST" action="{{ route($routePrefix . '.memo.updateStatus') }}">
                        @csrf
                        <input type="hidden" name="memo_id" id="rejectMemoId">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan:</label>
                            <textarea name="alasan" rows="3" 
                                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-red-500" 
                                      placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                        <div class="flex space-x-3">
                            <button name="action" value="tolak" 
                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                Tolak
                            </button>
                            <button type="button" onclick="closeModal()" 
                                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Revisi -->
        <div id="revisiModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Revisi Memo</h3>
                    <form method="POST" action="{{ route($routePrefix . '.memo.updateStatus') }}">
                        @csrf
                        <input type="hidden" name="memo_id" id="revisiMemoId">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Revisi:</label>
                            <textarea name="catatan_revisi" rows="3" 
                                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-500" 
                                      placeholder="Berikan catatan untuk revisi..." required></textarea>
                        </div>
                        <div class="flex space-x-3">
                            <button name="action" value="revisi" 
                                    class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                Kirim Revisi
                            </button>
                            <button type="button" onclick="closeModal()" 
                                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    let currentModal = null;

    function openModal(type, id) {
        const modals = {
            approve: 'approveModal',
            reject: 'rejectModal',
            revisi: 'revisiModal'
        };
        
        const modalId = modals[type];
        const modal = document.getElementById(modalId);
        
        if (type === 'approve') {
            document.getElementById('approveMemoId').value = id;
        } else if (type === 'reject') {
            document.getElementById('rejectMemoId').value = id;
        } else if (type === 'revisi') {
            document.getElementById('revisiMemoId').value = id;
        }
        
        modal.classList.remove('hidden');
        currentModal = modal;
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        if (currentModal) {
            currentModal.classList.add('hidden');
            currentModal = null;
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (currentModal && event.target === currentModal) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && currentModal) {
            closeModal();
        }
    });
</script>

@endsection