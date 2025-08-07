@extends('main')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Detail Memo - Manager</h2>
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    {{ ucfirst($memo->status) }}
                </span>
            </div>
        </div>

        <div class="px-6 py-4">

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
                                @if($division->asistenManagers->count() > 0)
                                    <option value="{{ $division->nama }}" 
                                        data-asmen="{{ $division->asistenManagers->first()->name }}">
                                        {{ $division->nama }} (Asmen: {{ $division->asistenManagers->first()->name }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Hanya divisi dengan Asisten Manager aktif yang ditampilkan</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="catatan" rows="3" class="w-full border border-gray-300 rounded-md p-2"></textarea>
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
            </div>

            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const divisiSelect = document.getElementById('divisiSelect');
                const forwardForm = document.getElementById('forwardForm');
                
                forwardForm.addEventListener('submit', function(e) {
                    if (!divisiSelect.value) {
                        e.preventDefault();
                        alert('Silakan pilih divisi tujuan terlebih dahulu');
                    }
                });
            });
            </script>
            @endpush
            @endif

            <!-- Riwayat memo -->
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
@endsection