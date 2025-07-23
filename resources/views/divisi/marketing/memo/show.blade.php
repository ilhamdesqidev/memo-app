@extends('layouts.divisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back button and title -->
    <div class="flex items-center mb-6">
        <a href="{{ route('marketing.memo.index') }}" class="text-gray-600 hover:text-gray-800 mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Memo</h1>
    </div>

    <!-- Memo Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <!-- Memo Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <span class="font-semibold text-blue-600">No. {{ $memo->nomor }}</span>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ $memo->tanggal->format('d F Y') }}</span>
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
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$memo->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusText[$memo->status] ?? $memo->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Memo Content -->
        <div class="p-6 space-y-6">
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Kepada</p>
                    <p class="text-base">{{ $memo->kepada }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Dari</p>
                    <p class="text-base">{{ $memo->dari }}</p>
                </div>
            </div>

            <!-- Perihal -->
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Perihal</p>
                <p class="text-base font-semibold">{{ $memo->perihal }}</p>
            </div>

            <!-- Lampiran Count -->
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Lampiran</p>
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 mr-2">
                        {{ $memo->lampiran ?? 0 }}
                    </span>
                    <span class="text-base">dokumen terlampir</span>
                </div>
            </div>

            <!-- Isi Memo -->
            <div class="border-t border-gray-200 pt-4">
                <p class="text-sm font-medium text-gray-500 mb-2">Isi Memo</p>
                <div class="prose max-w-none">
                    {!! nl2br(e($memo->isi)) !!}
                </div>
            </div>

            <!-- Signature Section -->
            @if($memo->signature)
            <div class="mt-6 border-t pt-4">
                <p class="text-sm font-medium text-gray-500 mb-2">Tanda Tangan</p>
                
                @if(file_exists(storage_path('app/public/'.$memo->signature)))
                    @if(Str::endsWith($memo->signature, '.pdf'))
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <embed src="{{ url('storage/'.$memo->signature) }}" 
                            type="application/pdf"
                            width="100%"
                            height="300px">
                        <p class="text-center mt-2 text-sm text-gray-500">
                            {{ $memo->dari }}
                        </p>
                    </div>
                    @else
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <img src="{{ url('storage/'.$memo->signature) }}" 
                            alt="Tanda Tangan"
                            class="max-h-40 mx-auto mb-2">
                        <p class="text-sm text-gray-500">
                            {{ $memo->dari }}
                        </p>
                    </div>
                    @endif
                @endif
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        @if(auth()->user()->divisi->nama === $memo->divisi_tujuan && $memo->status === 'pending')
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
            <form method="POST" action="{{ route('marketing.memo.approve', $memo->id) }}">
                @csrf
                @method('PUT')
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Setujui
                </button>
            </form>
            <button onclick="openRejectModal({{ $memo->id }})" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Tolak
            </button>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Alasan Penolakan</h3>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PUT')
            <textarea name="rejection_reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4" placeholder="Masukkan alasan penolakan..." required></textarea>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(memoId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/marketing/memo/${memoId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection