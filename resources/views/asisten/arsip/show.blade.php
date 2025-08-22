@extends('layouts.asisten')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Detail Memo - Arsip</h1>
            <a href="{{ route('asisten.arsip') }}" 
               class="flex items-center px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Arsip
            </a>
        </div>
        <p class="text-gray-600 mt-2">Informasi lengkap memo {{ $memo->nomor }} dari divisi {{ $memo->dari }}</p>
    </div>

    <!-- Memo Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
        <div class="px-8 py-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900">{{ $memo->perihal }}</h2>
            <div class="flex items-center mt-2">
                @php
                    $statusConfig = [
                        'disetujui' => ['bg-green-100 text-green-700', 'Disetujui'],
                        'ditolak' => ['bg-red-100 text-red-700', 'Ditolak'],
                    ];
                    [$classes, $text] = $statusConfig[$memo->status] ?? ['bg-gray-100 text-gray-700', ucfirst($memo->status)];
                @endphp
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $classes }} shadow-sm mr-4">
                    {{ $text }}
                </span>
                <span class="text-sm text-gray-500">Nomor: {{ $memo->nomor }}</span>
            </div>
        </div>

        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dari -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Dari</h3>
                    <p class="text-sm font-semibold text-gray-900">{{ $memo->dari }}</p>
                    <p class="text-sm text-gray-600">{{ $memo->dibuatOleh->name }}</p>
                </div>

                <!-- Kepada -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Kepada</h3>
                    <p class="text-sm font-semibold text-gray-900">{{ $memo->divisiTujuan->nama }}</p>
                    <p class="text-sm text-gray-600">{{ $memo->kepada }}</p>
                </div>

                <!-- Tanggal -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Dibuat</h3>
                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($memo->created_at)->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Selesai</h3>
                    @if($memo->status == 'disetujui' && $memo->approval_date)
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($memo->approval_date)->format('d/m/Y H:i') }}</p>
                    @elseif($memo->status == 'ditolak' && $memo->rejection_date)
                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($memo->rejection_date)->format('d/m/Y H:i') }}</p>
                    @else
                        <p class="text-sm text-gray-900">-</p>
                    @endif
                </div>

                <!-- Disetujui/Ditolak Oleh -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">
                        {{ $memo->status == 'disetujui' ? 'Disetujui Oleh' : 'Ditolak Oleh' }}
                    </h3>
                    @if($memo->status == 'disetujui' && $memo->disetujuiOleh)
                        <p class="text-sm text-gray-900">{{ $memo->disetujuiOleh->name }}</p>
                    @elseif($memo->status == 'ditolak' && $memo->ditolakOleh)
                        <p class="text-sm text-gray-900">{{ $memo->ditolakOleh->name }}</p>
                    @else
                        <p class="text-sm text-gray-900">-</p>
                    @endif
                </div>

                <!-- Lampiran -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Lampiran</h3>
                    <p class="text-sm text-gray-900">{{ $memo->lampiran ?: 'Tidak ada lampiran' }}</p>
                </div>
            </div>

            <!-- Isi Memo -->
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Isi Memo</h3>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-900 whitespace-pre-line">{{ $memo->isi }}</p>
                </div>
            </div>
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

    <!-- Action Buttons -->
    <div class="flex justify-end gap-3">
        @if($memo->status == 'disetujui')
            <a href="{{ route('asisten.arsip.pdf', $memo->id) }}" 
               target="_blank"
               class="flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download PDF
            </a>
        @endif
    </div>
</div>
@endsection