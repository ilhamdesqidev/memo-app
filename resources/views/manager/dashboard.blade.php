@extends('main')

@section('title', 'Dashboard Manager')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Manager</h1>
                    <p class="mt-2 text-lg text-gray-600">
                        Selamat datang, <span class="font-semibold text-blue-600">{{ auth()->user()->name }} </span> sebagai <span class="font-semibold text-blue-600">{{ auth()->user()->jabatan }}</span>.
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-200">
                        <p class="text-sm text-gray-600">Divisi</p>
                        <p class="font-semibold text-blue-800">{{ auth()->user()->divisi->nama ?? 'Belum ditentukan' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Memo Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Semua Memo</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalMemo }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Approval Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Menunggu Persetujuan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingMemo }}</p>
                        <p class="text-xs text-gray-500 mt-1">Memo untuk Manager</p>
                    </div>
                </div>
            </div>

            <!-- Approved Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Telah Disetujui</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $approvedMemo }}</p>
                        <p class="text-xs text-gray-500 mt-1">Semua Memo Disetujui</p>
                    </div>
                </div>
            </div>

            <!-- Rejected Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Ditolak</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $rejectedMemo }}</p>
                        <p class="text-xs text-gray-500 mt-1">Semua Memo Ditolak</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tindakan Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('manager.memo.inbox') }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 hover:border-blue-300 transition-all duration-200 group">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4m16 0l-2-2m-2 2l2-2"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Lihat Memo Masuk</p>
                            <p class="text-sm text-gray-500">Review memo yang memerlukan persetujuan</p>
                        </div>
                        <div class="ml-auto">
                            @if($pendingMemo > 0)
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $pendingMemo }} baru
                            </span>
                            @endif
                        </div>
                    </a>

                    <a href="{{ route('manager.arsip.index') }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 hover:border-green-300 transition-all duration-200 group">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Arsip Memo</p>
                            <p class="text-sm text-gray-500">Lihat memo yang telah diproses</p>
                        </div>
                    </a>

                    <a href="#" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 hover:border-purple-300 transition-all duration-200 group">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Laporan Divisi</p>
                            <p class="text-sm text-gray-500">Lihat ringkasan kinerja divisi</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-2 h-2 
                            @if($activity->aksi == 'penerusan_ke_divisi' || $activity->aksi == 'persetujuan') bg-blue-400
                            @elseif($activity->aksi == 'penolakan_final' || $activity->aksi == 'penolakan') bg-red-400
                            @elseif($activity->aksi == 'penandatanganan') bg-green-400
                            @else bg-gray-400 @endif
                            rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $activity->user->name }}: 
                                @if($activity->aksi == 'penerusan_ke_divisi' || $activity->aksi == 'persetujuan')
                                    Menyetujui memo
                                @elseif($activity->aksi == 'penolakan_final' || $activity->aksi == 'penolakan')
                                    Menolak memo
                                @elseif($activity->aksi == 'penandatanganan')
                                    Menandatangani memo
                                @else
                                    {{ $activity->aksi }}
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($activity->waktu)->diffForHumans() }}
                            </p>
                            @if($activity->catatan)
                            <p class="text-xs text-gray-600 mt-1">Catatan: {{ $activity->catatan }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500">Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('manager.arsip.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat semua aktivitas →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection