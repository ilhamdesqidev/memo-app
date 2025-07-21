@extends('layouts.divisi')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('sipil.memo.index') }}" class="text-gray-600 hover:text-gray-800 mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Detail Memo</h2>
            </div>
        </div>

        <!-- Memo Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <!-- Memo Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-blue-600">No. {{ $memo->nomor }}</span>
                    <span class="text-sm text-gray-500">{{ $memo->tanggal->format('d F Y') }}</span>
                </div>
            </div>

            <!-- Memo Content -->
            <div class="p-6 space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kepada</p>
                        <p class="text-lg">{{ $memo->kepada }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dari</p>
                        <p class="text-lg">{{ $memo->dari }}</p>
                    </div>
                </div>

                <!-- Perihal -->
                <div>
                    <p class="text-sm font-medium text-gray-500">Perihal</p>
                    <p class="text-lg font-semibold">{{ $memo->perihal }}</p>
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
                    <h3 class="text-lg font-medium mb-2">Tanda Tangan</h3>
                    
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
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Approve
                    </button>
                </form>
                
                <button onclick="openRejectModal({{ $memo->id }})" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reject
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Alasan Penolakan</h3>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PUT')
            <textarea name="rejection_reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4" placeholder="Masukkan alasan penolakan..." required></textarea>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(memoId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/manager/memo/${memoId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection