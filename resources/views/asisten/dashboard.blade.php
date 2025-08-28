@extends('layouts.asisten')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'amber': {
                        50: '#fffbeb',
                        100: '#fef3c7',
                        400: '#fbbf24',
                        600: '#d97706',
                        700: '#b45309',
                    },
                    'emerald': {
                        50: '#ecfdf5',
                        100: '#d1fae5',
                        400: '#34d399',
                        600: '#059669',
                        700: '#047857',
                    },
                    'red': {
                        50: '#fef2f2',
                        400: '#f87171',
                        600: '#dc2626',
                    },
                    'blue': {
                        50: '#eff6ff',
                        400: '#60a5fa',
                        600: '#2563eb',
                        700: '#1d4ed8',
                    },
                    'purple': {
                        50: '#faf5ff',
                        100: '#f3e8ff',
                        600: '#9333ea',
                        700: '#7c3aed',
                    }
                }
            }
        }
    }
</script>

<div class="min-h-screen bg-gray-50">
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                        <p class="mt-2 text-sm text-gray-600">Selamat datang di dashboard divisi {{ $userDivisi }}!</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            {{ date('l, j F Y') }}
                        </div>
                        <div class="h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Pending Memos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-amber-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingMemos }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        @if($pendingMemos > 0)
                            <span class="inline-flex items-center text-sm text-amber-600 font-medium">
                                Needs review
                            </span>
                        @else
                            <span class="inline-flex items-center text-sm text-emerald-600 font-medium">
                                All caught up
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Approved Memos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Approved</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $approvedMemos }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('asisten.arsip') }}" class="inline-flex items-center text-sm text-emerald-600 hover:text-emerald-700 font-medium group">
                            View archive
                            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Rejected Memos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-red-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Rejected</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $rejectedMemos }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        @if($rejectedMemos > 0)
                            <span class="text-sm text-red-600 font-medium">
                                Needs attention
                            </span>
                        @else
                            <span class="text-sm text-emerald-600 font-medium">
                                All good
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Total Memos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 hover:border-blue-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Total Memos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingMemos + $approvedMemos + $rejectedMemos }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm text-blue-600 font-medium">
                            All time
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Quick Actions -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            <p class="text-sm text-gray-600 mt-1">Kelola memo dengan efisien</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Create Memo -->
                                <a href="#" class="group block">
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-emerald-300 hover:shadow-md transition-all duration-200 group-hover:bg-emerald-50">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </div>
                                            <h4 class="ml-3 text-sm font-semibold text-gray-900">Buat Memo</h4>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">Buat memo baru untuk aktivitas divisi</p>
                                        <div class="flex items-center text-sm text-emerald-600 font-medium group-hover:text-emerald-700">
                                            Create Memo
                                            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>

                                <!-- View Archive -->
                                <a href="{{ route('asisten.arsip') }}" class="group block">
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 group-hover:bg-blue-50">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <h4 class="ml-3 text-sm font-semibold text-gray-900">Kelola Arsip</h4>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">Lihat dan kelola arsip memo divisi</p>
                                        <div class="flex items-center text-sm text-blue-600 font-medium group-hover:text-blue-700">
                                            Go to Archive
                                            @if($approvedMemos > 0)
                                                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $approvedMemos }}</span>
                                            @endif
                                            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>

                                <!-- Reports -->
                                <a href="#" class="group block">
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 group-hover:bg-purple-50">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                            </div>
                                            <h4 class="ml-3 text-sm font-semibold text-gray-900">Laporan</h4>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">Lihat statistik dan laporan memo</p>
                                        <div class="flex items-center text-sm text-purple-600 font-medium group-hover:text-purple-700">
                                            View Reports
                                            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>

                                <!-- Settings -->
                                <a href="#" class="group block">
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-gray-400 hover:shadow-md transition-all duration-200 group-hover:bg-gray-50">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <h4 class="ml-3 text-sm font-semibold text-gray-900">Settings</h4>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">Konfigurasi dashboard dan preferensi</p>
                                        <div class="flex items-center text-sm text-gray-600 font-medium group-hover:text-gray-700">
                                            Open Settings
                                            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Recent Activity -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                            <p class="text-sm text-gray-600 mt-1">Update terbaru dari memo divisi</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($recentMemos as $memo)
                                    <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                        @if($memo->status == 'disetujui')
                                            <div class="w-3 h-3 bg-emerald-400 rounded-full mt-1.5 flex-shrink-0"></div>
                                        @elseif($memo->status == 'ditolak')
                                            <div class="w-3 h-3 bg-red-400 rounded-full mt-1.5 flex-shrink-0"></div>
                                        @elseif($memo->status == 'diajukan')
                                            <div class="w-3 h-3 bg-blue-400 rounded-full mt-1.5 flex-shrink-0"></div>
                                        @else
                                            <div class="w-3 h-3 bg-amber-400 rounded-full mt-1.5 flex-shrink-0"></div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                @if($memo->status == 'disetujui')
                                                    Memo disetujui
                                                @elseif($memo->status == 'ditolak')
                                                    Memo ditolak
                                                @elseif($memo->status == 'diajukan')
                                                    Memo diajukan
                                                @else
                                                    Memo {{ $memo->status }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($memo->perihal, 30) }} • {{ $memo->updated_at->diffForHumans() }}</p>
                                            @if($memo->status == 'disetujui')
                                                <div class="mt-1">
                                                    <a href="{{ route('asisten.arsip.show', $memo->id) }}" class="text-xs text-emerald-600 hover:text-emerald-800">Lihat di arsip →</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-500">Belum ada aktivitas memo</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($recentMemos->count() > 0)
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <a href="{{ route('asisten.arsip') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium group w-full justify-center">
                                        View all activity
                                        <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection