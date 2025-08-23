@extends('layouts.asisten')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Memo - Arsip</h1>
                <p class="text-gray-600 mt-2">Informasi lengkap memo {{ $memo->nomor }} dari divisi {{ $memo->dari }}</p>
            </div>
            <a href="{{ route('asisten.arsip') }}" 
               class="flex items-center px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Arsip
            </a>
        </div>
    </div>

    <!-- Memo Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8 memo-card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900">{{ $memo->perihal }}</h2>
            <div class="flex flex-wrap items-center mt-2 gap-2">
                @php
                    $statusConfig = [
                        'disetujui' => ['bg-green-100 text-green-700', 'Disetujui', 'fa-check-circle'],
                        'ditolak' => ['bg-red-100 text-red-700', 'Ditolak', 'fa-times-circle'],
                        'menunggu' => ['bg-yellow-100 text-yellow-700', 'Menunggu', 'fa-clock'],
                        'direvisi' => ['bg-blue-100 text-blue-700', 'Direvisi', 'fa-edit'],
                    ];
                    [$classes, $text, $icon] = $statusConfig[$memo->status] ?? ['bg-gray-100 text-gray-700', ucfirst($memo->status), 'fa-file-alt'];
                @endphp
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $classes }} shadow-sm status-badge">
                    <i class="fas {{ $icon }} mr-1"></i>
                    {{ $text }}
                </span>
                <span class="text-sm text-gray-500">Nomor: {{ $memo->nomor }}</span>
            </div>
        </div>

        <div class="px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dari -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-user-circle mr-2"></i> Dari
                    </h3>
                    <p class="text-sm font-semibold text-gray-900">{{ $memo->dari }}</p>
                    <p class="text-sm text-gray-600">{{ $memo->dibuatOleh->name ?? 'Tidak diketahui' }}</p>
                </div>

                <!-- Kepada -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-users mr-2"></i> Kepada
                    </h3>
                    <p class="text-sm font-semibold text-gray-900">{{ $memo->divisiTujuan->nama ?? $memo->kepada }}</p>
                    <p class="text-sm text-gray-600">{{ $memo->kepada }}</p>
                </div>

                <!-- Tanggal -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i> Tanggal Dibuat
                    </h3>
                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($memo->created_at)->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i> Tanggal Selesai
                    </h3>
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
                    <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-user-check mr-2"></i>
                        {{ $memo->status == 'disetujui' ? 'Disetujui Oleh' : ($memo->status == 'ditolak' ? 'Ditolak Oleh' : 'Status') }}
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
                    <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-paperclip mr-2"></i> Lampiran
                    </h3>
                    <p class="text-sm text-gray-900">{{ $memo->lampiran ?: 'Tidak ada lampiran' }}</p>
                </div>
            </div>

            <!-- Isi Memo Button -->
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                    <i class="fas fa-file-alt mr-2"></i> Isi Memo
                </h3>
                <button onclick="openMemoModal()" 
                        class="inline-flex items-center px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl transition-colors duration-200 w-full text-left">
                    <i class="fas fa-file-alt mr-3 text-gray-600"></i>
                    <div>
                        <p class="font-medium text-gray-800">Klik untuk melihat isi memo</p>
                        <p class="text-sm text-gray-500">Klik tombol ini untuk membaca isi memo lengkap</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Riwayat Memo -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-history mr-2 text-blue-600"></i> Riwayat Memo
            </h3>
        </div>
        <div class="px-6 py-4">
            @if($memo->logs && $memo->logs->count() > 0)
                <ul class="space-y-4">
                    @foreach($memo->logs->sortBy('waktu') as $log)
                    <li class="flex items-start space-x-3 p-3 rounded-lg log-item">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold shadow-md">
                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                <p class="font-medium text-gray-800">{{ $log->user->name ?? 'Sistem' }}</p>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->waktu)->format('d M Y H:i') }}</span>
                            </div>
                            <p class="text-sm mt-2">
                                @if(str_contains(strtolower($log->aksi), 'setuju'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> {{ $log->aksi }}
                                    </span>
                                @elseif(str_contains(strtolower($log->aksi), 'tolak'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> {{ $log->aksi }}
                                    </span>
                                @elseif(str_contains(strtolower($log->aksi), 'revisi'))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-edit mr-1"></i> {{ $log->aksi }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-info-circle mr-1"></i> {{ $log->aksi }}
                                    </span>
                                @endif
                            </p>
                            @if($log->catatan)
                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <span class="block text-gray-500 text-xs mb-1 font-medium">Catatan:</span>
                                {{ $log->catatan }}
                            </div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-history text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada riwayat memo.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-end gap-3">
        @if($memo->status == 'disetujui')
            <a href="{{ route('asisten.arsip.pdf', $memo->id) }}" 
               target="_blank"
               class="flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-200 shadow-sm">
                <i class="fas fa-file-pdf mr-2"></i>
                Download PDF
            </a>
        @endif
        
        <a href="{{ route('asisten.arsip') }}" 
           class="flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Arsip
        </a>
    </div>
</div>

<!-- Modal untuk Isi Memo -->
<div id="memoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Isi Memo</h3>
                <button onclick="closeMemoModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="max-h-96 overflow-y-auto">
                <div id="memoContent" class="text-gray-700 leading-relaxed break-words whitespace-pre-line">{{ $memo->isi }}</div>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-end pt-4 mt-4 border-t border-gray-200">
                <button onclick="closeMemoModal()" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .memo-card {
        transition: all 0.2s ease;
    }
    .memo-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .status-badge {
        transition: transform 0.2s ease;
    }
    .status-badge:hover {
        transform: scale(1.05);
    }
    .log-item {
        transition: background-color 0.2s ease;
    }
    .log-item:hover {
        background-color: #f8fafc;
    }
</style>

<script>
    function openMemoModal() {
        // Bersihkan tag HTML dari isi memo sebelum menampilkan
        const memoContent = document.getElementById('memoContent');
        memoContent.innerHTML = memoContent.textContent.replace(/<[^>]*>/g, '');
        
        document.getElementById('memoModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeMemoModal() {
        document.getElementById('memoModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('memoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMemoModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMemoModal();
        }
    });

    // Tambahkan efek hover pada elemen
    document.addEventListener('DOMContentLoaded', function() {
        const memoCards = document.querySelectorAll('.memo-card');
        const statusBadges = document.querySelectorAll('.status-badge');
        const logItems = document.querySelectorAll('.log-item');
        
        const addHoverEffect = (items) => {
            items.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        };
        
        addHoverEffect(memoCards);
        addHoverEffect(statusBadges);
        addHoverEffect(logItems);
    });
</script>
@endsection