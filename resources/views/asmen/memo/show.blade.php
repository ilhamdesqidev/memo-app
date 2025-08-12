@extends('layouts.asisten_manager')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl"> <!-- Tambahkan max-w-4xl untuk batas lebar -->
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

            <div class="mb-4">
                <p class="text-sm text-gray-500">Isi Memo</p>
                <div class="prose max-w-none mt-2 break-words"> <!-- Tambahkan break-words -->
                    {!! $memo->isi !!}
                </div>
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

                    <form action="{{ route('asmen.memo.request-revision', $memo->id) }}" method="POST" class="flex-1 min-w-[250px]"> <!-- Tambahkan min-w-[250px] -->
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

                    <form action="{{ route('asmen.memo.reject', $memo->id) }}" method="POST" class="flex-1 min-w-[250px]"> <!-- Tambahkan min-w-[250px] -->
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
                        <div class="flex-1 min-w-0"> <!-- Tambahkan min-w-0 untuk mencegah overflow -->
                            <div class="text-sm font-medium text-gray-900 truncate">{{ $log->user->name }}</div> <!-- Tambahkan truncate -->
                            <div class="text-sm text-gray-500">{{ $log->aksi }} - {{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}</div>
                            <div class="mt-1 text-sm text-gray-700 break-words">{{ $log->catatan }}</div> <!-- Tambahkan break-words -->
                        </div>
                    </div>
                    @endforeach
                </div>
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