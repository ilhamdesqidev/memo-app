@extends('layouts.asisten_manager')

@section('title', 'Detail Memo - Asisten Manager')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
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

        <!-- Info Memo -->
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Nomor Memo</p>
                    <p class="font-medium">{{ $memo->nomor ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($memo->created_at)->format('d F Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dari</p>
                    <p class="font-medium">{{ $memo->dari }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kepada</p>
                    <p class="font-medium">{{ $memo->divisiTujuan->nama ?? '-' }}</p>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Perihal</p>
                <p class="font-medium">{{ $memo->perihal }}</p>
            </div>

            <!-- Isi Memo -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Isi Memo</h4>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-gray-700">
                    {!! nl2br(e($memo->isi)) !!}
                </div>
            </div>

            <!-- Lampiran -->
            @if($memo->lampiran)
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Lampiran</h4>
                <a href="{{ asset('storage/' . $memo->lampiran) }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 hover:bg-blue-100 transition">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828M7 7h.01"/>
                    </svg>
                    Lihat Lampiran
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Memo -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Riwayat Memo</h3>
        </div>
        <div class="px-6 py-4">
            @if($memo->logs && $memo->logs->count() > 0)
                <ul class="space-y-4">
                    @foreach($memo->logs as $log)
                    <li class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                            {{ substr($log->user->name,0,1) }}
                        </div>
                        <div>
                            <div class="flex justify-between items-center">
                                <p class="font-medium text-gray-800">{{ $log->user->name }}</p>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}</span>
                            </div>
                            <p class="text-sm mt-1">
                                @if(str_contains(strtolower($log->aksi), 'setuju'))
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-800 text-xs">{{ $log->aksi }}</span>
                                @elseif(str_contains(strtolower($log->aksi), 'tolak'))
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-800 text-xs">{{ $log->aksi }}</span>
                                @elseif(str_contains(strtolower($log->aksi), 'revisi'))
                                    <span class="px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs">{{ $log->aksi }}</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-gray-100 text-gray-800 text-xs">{{ $log->aksi }}</span>
                                @endif
                            </p>
                            @if($log->catatan)
                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <span class="block text-gray-500 text-xs mb-1">Catatan:</span>
                                {{ $log->catatan }}
                            </div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-center py-6">Belum ada riwayat memo.</p>
            @endif
        </div>
    </div>

    <!-- PDF Actions -->
    @if($memo->status == 'disetujui')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-6 text-center">
            <h5 class="text-lg font-medium text-gray-800 mb-2">Dokumen PDF</h5>
            <p class="text-gray-500 mb-4">Memo telah disetujui dan siap diunduh</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('asmen.memo.view-pdf', $memo->id) }}" target="_blank"
                   class="px-5 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                    Lihat PDF
                </a>
                <a href="{{ route('asmen.memo.pdf', $memo->id) }}"
                   class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Unduh PDF
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
