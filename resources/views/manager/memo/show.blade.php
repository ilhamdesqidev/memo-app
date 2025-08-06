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
            <!-- Konten detail memo sama seperti di asisten manager -->
            <!-- ... -->

            @if($canProcess)
            <div class="mt-6 border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Tindakan</h3>
                <div class="flex flex-wrap gap-3">
                    <!-- Form Setujui dengan Opsi Teruskan -->
                    <form action="{{ route('manager.memo.approve', $memo->id) }}" method="POST" class="flex-1 min-w-[250px]">
                        @csrf
                        <div class="mb-3">
                            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea name="catatan" id="catatan" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="divisi_tujuan" class="block text-sm font-medium text-gray-700">Tindakan Lanjutan</label>
                            <select name="divisi_tujuan" id="divisi_tujuan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Setujui dan simpan</option>
                                @foreach($otherDivisions as $division)
                                    @if($division->nama != $memo->dari)
                                        <option value="{{ $division->nama }}">Setujui dan teruskan ke {{ $division->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-center mb-3">
                            <input type="checkbox" name="include_signature" id="include_signature" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="include_signature" class="ml-2 block text-sm text-gray-700">Sertakan tanda tangan digital</label>
                        </div>
                        
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Proses Memo
                        </button>
                    </form>

                    <!-- Form Tolak -->
                    <form action="{{ route('manager.memo.reject', $memo->id) }}" method="POST" class="flex-1 min-w-[250px]">
                        @csrf
                        <div class="mb-3">
                            <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan Penolakan *</label>
                            <textarea name="alasan" id="alasan" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Tolak Memo
                        </button>
                    </form>
                </div>
            </div>
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