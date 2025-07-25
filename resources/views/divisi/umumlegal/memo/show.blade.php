@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-4xl">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <a href="{{ route('umumlegal.memo.index') }}" 
           class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Detail Memo</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $memo->nomor }}</p>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header Info -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-medium text-gray-900">{{ $memo->perihal }}</h2>
                @php
                    $statusClasses = [
                        'draft' => 'bg-gray-100 text-gray-700',
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'approved' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                    ];
                    $statusText = [
                        'draft' => 'Draft',
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ];
                @endphp
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $statusClasses[$memo->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $statusText[$memo->status] ?? $memo->status }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                <div>
                    <p class="text-gray-500 mb-1">Dari</p>
                    <p class="font-medium text-gray-900">{{ $memo->dari }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Kepada</p>
                    <p class="font-medium text-gray-900">{{ $memo->kepada }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Tanggal</p>
                    <p class="font-medium text-gray-900">{{ $memo->tanggal->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Lampiran -->
            @if($memo->lampiran)
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                </svg>
                <span class="text-sm text-gray-600">{{ $memo->lampiran }} dokumen terlampir</span>
            </div>
            @endif

            <!-- Isi Memo -->
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-3">Isi Memo</h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed p-4 bg-gray-50 rounded-lg">
                    {!! nl2br(e($memo->isi)) !!}
                </div>
            </div>

            <!-- Signature -->
            @if($memo->signature)
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-3">Tanda Tangan</h3>
                @if(file_exists(storage_path('app/public/'.$memo->signature)))
                    @if(Str::endsWith($memo->signature, '.pdf'))
                    <div class="border border-gray-200 rounded-lg p-4">
                        <embed src="{{ url('storage/'.$memo->signature) }}" 
                            type="application/pdf"
                            width="100%"
                            height="300px">
                        <p class="text-center mt-3 text-sm text-gray-600">{{ $memo->dari }}</p>
                    </div>
                    @else
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <img src="{{ url('storage/'.$memo->signature) }}" 
                            alt="Tanda Tangan"
                            class="max-h-32 mx-auto mb-2">
                        <p class="text-sm text-gray-600">{{ $memo->dari }}</p>
                    </div>
                    @endif
                @endif
            </div>
            @endif
        </div>

        <!-- Approval History -->
        <div class="border-t border-gray-100 p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-4">Riwayat Persetujuan</h3>
            @if($memo->logs->count() > 0)
                <div class="space-y-3">
                    @foreach ($memo->logs as $log)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full {{ $log->aksi === 'approved' ? 'bg-green-500' : ($log->aksi === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $log->divisi }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst($log->aksi) }} • {{ $log->user->name ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">{{ $log->waktu }}</p>
                            @if($log->catatan)
                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($log->catatan, 30) }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">Belum ada riwayat persetujuan</p>
            @endif
        </div>

        <!-- Actions -->
        @if(auth()->user()->divisi->nama === $memo->divisi_tujuan && $memo->status === 'pending')
        <div class="border-t border-gray-100 p-6 bg-gray-50">
            <div class="flex space-x-3">
                <form method="POST" action="{{ route('umumlegal.memo.approve', $memo->id) }}" class="flex-1">
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
        @endif
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

<script>
function openRejectModal(memoId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/umumlegal/memo/${memoId}/reject`;
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
</script>
@endsection