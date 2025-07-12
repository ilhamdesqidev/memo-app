@extends('layouts.divisi')

@section('content')
<div class="w-full p-6 font-sans">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-900 via-blue-700 to-blue-500 text-white p-6 rounded-xl shadow-lg mb-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-blue-700 opacity-90"></div>
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Persetujuan Memo
            </h1>
            <p class="text-blue-100 text-sm">Kelola persetujuan memo dari staf</p>
        </div>
    </div>

    @if($memos->isEmpty())
        <!-- Empty State -->
        <div class="text-center bg-white p-12 rounded-xl shadow-md border-2 border-dashed border-gray-200">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-xl text-gray-700 font-semibold mt-4 mb-1">Tidak Ada Memo</h3>
            <p class="text-gray-500 text-sm max-w-md mx-auto">Tidak ada memo yang memerlukan persetujuan saat ini.</p>
        </div>
    @else
        <!-- Memo Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            @foreach($memos as $memo)
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200 border-l-4 border-yellow-500 relative overflow-hidden group">
                    <!-- Gradient top border -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-500 to-yellow-800"></div>
                    
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                        <span class="text-sm font-bold text-yellow-800 bg-gradient-to-r from-yellow-100 to-yellow-200 px-3 py-1 rounded-full border border-yellow-200">
                            {{ $memo->nomor }}
                        </span>
                        <span class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-lg border border-gray-200">
                            {{ $memo->tanggal->format('d M Y') }}
                        </span>
                    </div>
                    
                    <!-- Memo Info -->
                    <div class="mb-6 space-y-3">
                        <div class="flex flex-col px-3 py-2 bg-yellow-50 rounded-lg border-l-3 border-yellow-500">
                            <strong class="text-xs text-yellow-700 uppercase tracking-wider mb-1">Kepada:</strong>
                            <span class="text-sm text-gray-700">{{ $memo->kepada }}</span>
                        </div>
                        
                        <div class="flex flex-col px-3 py-2 bg-yellow-50 rounded-lg border-l-3 border-yellow-500">
                            <strong class="text-xs text-yellow-700 uppercase tracking-wider mb-1">Dari:</strong>
                            <span class="text-sm text-gray-700">{{ $memo->dari }}</span>
                        </div>
                        
                        <div class="flex flex-col px-3 py-2 bg-yellow-50 rounded-lg border-l-3 border-yellow-500">
                            <strong class="text-xs text-yellow-700 uppercase tracking-wider mb-1">Perihal:</strong>
                            <span class="text-sm text-gray-700">{{ $memo->perihal }}</span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('manager.memo.show', $memo->id) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-semibold hover:from-blue-600 hover:to-blue-700 transition-all">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Review
                        </a>
                        
                        <form action="#" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-semibold hover:from-green-600 hover:to-green-700 transition-all">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approve
                            </button>
                        </form>
                        
                        <button onclick="openRejectModal({{ $memo->id }})" class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold hover:from-red-600 hover:to-red-700 transition-all">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reject
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Alasan Penolakan</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
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

document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to memo cards
    document.querySelectorAll('.group').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('transform', '-translate-y-1');
            this.classList.add('shadow-lg');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('transform', '-translate-y-1');
            this.classList.remove('shadow-lg');
        });
    });
});
</script>
@endsection