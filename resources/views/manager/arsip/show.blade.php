@extends('main')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Memo</h1>
            <p class="text-gray-600">Informasi lengkap mengenai memo</p>
        </div>
        <a href="{{ route('manager.arsip.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Card Container -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">{{ $memo->nomor }}</h2>
                @php
                    $statusColor = $memo->status == 'disetujui' ? 'bg-green-500' : 'bg-red-500';
                    $statusText = $memo->status == 'disetujui' ? 'Disetujui' : 'Ditolak';
                @endphp
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }} text-white">
                    {{ $statusText }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Info Utama -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Dari</h3>
                    <p class="text-gray-900 font-medium">{{ $memo->dari }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Kepada</h3>
                    <p class="text-gray-900 font-medium">{{ $memo->kepada }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Dibuat</h3>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($memo->created_at)->format('d F Y') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Selesai</h3>
                    <p class="text-gray-900">
                        @if($memo->status == 'disetujui' && $memo->approval_date)
                            {{ \Carbon\Carbon::parse($memo->approval_date)->format('d F Y') }}
                        @elseif($memo->status == 'ditolak' && $memo->rejection_date)
                            {{ \Carbon\Carbon::parse($memo->rejection_date)->format('d F Y') }}
                        @else
                            {{ \Carbon\Carbon::parse($memo->updated_at)->format('d F Y') }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Perihal -->
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Perihal</h3>
                <p class="text-gray-900 text-lg font-medium">{{ $memo->perihal }}</p>
            </div>

            <!-- Isi Memo -->
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Isi Memo</h3>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="text-gray-800 whitespace-pre-line">{{ $memo->isi }}</p>
                </div>
            </div>

            <!-- Lampiran -->
            @if($memo->lampiran)
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Lampiran</h3>
                <div class="flex items-center bg-blue-50 p-3 rounded-lg border border-blue-200">
                    <i class="fas fa-paperclip text-blue-500 mr-2"></i>
                    <span class="text-blue-700">{{ $memo->lampiran }}</span>
                </div>
            </div>
            @endif

            <!-- Tanda Tangan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @if($memo->signature_path)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Tanda Tangan Pembuat</h3>
                    <div class="border border-gray-200 rounded-lg p-3">
                        <img src="{{ asset('storage/' . $memo->signature_path) }}" alt="Tanda Tangan Pembuat" class="h-16 object-contain mx-auto">
                        <p class="text-center text-sm text-gray-600 mt-2">{{ $memo->dibuatOleh->name ?? 'Unknown' }}</p>
                    </div>
                </div>
                @endif

                @if($memo->manager_signature_path)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Tanda Tangan Manager</h3>
                    <div class="border border-gray-200 rounded-lg p-3">
                        <img src="{{ asset('storage/' . $memo->manager_signature_path) }}" alt="Tanda Tangan Manager" class="h-16 object-contain mx-auto">
                        <p class="text-center text-sm text-gray-600 mt-2">{{ $memo->disetujuiOleh->name ?? 'Manager' }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Status Info -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Status Informasi</h3>
                <div class="space-y-2">
                    @if($memo->status == 'disetujui')
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Disetujui oleh: {{ $memo->disetujuiOleh->name ?? 'Manager' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>Pada: {{ \Carbon\Carbon::parse($memo->approval_date)->format('d F Y H:i') }}</span>
                        </div>
                    @elseif($memo->status == 'ditolak')
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-2"></i>
                            <span>Ditolak oleh: {{ $memo->ditolakOleh->name ?? 'Manager' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>Pada: {{ \Carbon\Carbon::parse($memo->rejection_date)->format('d F Y H:i') }}</span>
                        </div>
                        @if($memo->alasan_penolakan)
                        <div class="mt-2">
                            <h4 class="text-sm font-medium text-gray-500">Alasan Penolakan:</h4>
                            <p class="text-red-600">{{ $memo->alasan_penolakan }}</p>
                        </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('manager.arsip.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Arsip
                </a>
                @if($memo->status == 'disetujui')
                <a href="{{ route('manager.arsip.pdf', $memo->id) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-file-pdf mr-2"></i> Lihat PDF
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Riwayat Log -->
    @if($memo->logs && $memo->logs->count() > 0)
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Riwayat Aktivitas</h2>
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Log Aktivitas Memo</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($memo->logs->sortByDesc('waktu') as $log)
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-900">{{ $log->user->name ?? 'Sistem' }}</p>
                            <p class="text-sm text-gray-500">{{ $log->divisi }}</p>
                        </div>
                        <span class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-gray-700">{{ $log->aksi }}</p>
                        @if($log->catatan)
                        <p class="text-sm text-gray-500 mt-1">{{ $log->catatan }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Styles -->
<style>
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }
</style>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman detail memo dimuat');
    });
</script>
@endsection

@section('scripts')
<!-- Tambahkan script khusus untuk halaman ini jika diperlukan -->
@endsection