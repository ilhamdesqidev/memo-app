@extends('home')
@section('content')

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
        <p class="text-gray-600">Sistem Manajemen Surat Menyurat</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Surat Masuk -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Surat Masuk</p>
                    <p class="text-3xl font-bold text-blue-600">45</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2a2 2 0 00-2 2v3a2 2 0 002 2h2a2 2 0 002-2v-3a2 2 0 00-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-sm text-green-600">↑ 12% dari bulan lalu</span>
            </div>
        </div>

        <!-- Total Surat Keluar -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Surat Keluar</p>
                    <p class="text-3xl font-bold text-green-600">32</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-sm text-green-600">↑ 8% dari bulan lalu</span>
            </div>
        </div>

        <!-- Surat Pending -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu Persetujuan</p>
                    <p class="text-3xl font-bold text-yellow-600">8</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-sm text-yellow-600">Perlu tindak lanjut</span>
            </div>
        </div>

        <!-- Total User (Dynamic) -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"  fill="#NaNNaNNaN" viewBox="0 0 24 24" >
                        <path d="M5 5A2 2 0 1 0 5 9 2 2 0 1 0 5 5z"></path><path d="m19.5,10h-.7c-.84,0-1.61.42-2.08,1.11l-3.26,4.89h-2.93l-3.26-4.89c-.46-.7-1.24-1.11-2.08-1.11h-.7c-1.38,0-2.5,1.12-2.5,2.5v5.5h5v-3.7l1.87,2.81c.37.56.99.89,1.66.89h2.93c.67,0,1.29-.33,1.66-.89l1.87-2.81v3.7h5v-5.5c0-1.38-1.12-2.5-2.5-2.5Z"></path><path d="M19 5A2 2 0 1 0 19 9 2 2 0 1 0 19 5z"></path><path d="m14.51,10.17c.65-.67.65-1.74,0-2.41-.66-.67-1.69-.67-2.34,0l-.17.17-.17-.17c-.65-.67-1.69-.67-2.34,0-.65.68-.65,1.74,0,2.41l2.51,2.58,2.51-2.58Z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                @if($userGrowthPercentage > 0)
                    <span class="text-sm text-green-600">↑ {{ $userGrowthPercentage }}% dari bulan lalu</span>
                @elseif($userGrowthPercentage < 0)
                    <span class="text-sm text-red-600">↓ {{ abs($userGrowthPercentage) }}% dari bulan lalu</span>
                @else
                    <span class="text-sm text-gray-600">Tidak ada perubahan</span>
                @endif
                <br>
                <span class="text-sm text-purple-600">{{ $activeUsersToday }} user aktif hari ini</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <div class="p-2 bg-blue-500 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Buat Surat Baru</p>
                    <p class="text-sm text-gray-600">Tambah surat masuk/keluar</p>
                </div>
            </a>

            <a href="{{ route('admin.staff.index') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <div class="p-2 bg-green-500 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Kelola Pengguna</p>
                    <p class="text-sm text-gray-600">Tambah/edit pengguna ({{ $totalUsers }})</p>
                </div>
            </a>

            <a href="#" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <div class="p-2 bg-purple-500 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800">Laporan</p>
                    <p class="text-sm text-gray-600">Lihat statistik dan laporan</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity & Pending Approvals -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h2>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Surat masuk dari PT. ABC Corp telah diterima</p>
                        <p class="text-xs text-gray-500">2 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Surat keluar No. 001/2024 telah disetujui</p>
                        <p class="text-xs text-gray-500">5 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Pengguna baru Ahmad Fauzi telah terdaftar</p>
                        <p class="text-xs text-gray-500">1 hari yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Laporan bulanan telah dibuat</p>
                        <p class="text-xs text-gray-500">2 hari yang lalu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Menunggu Persetujuan</h2>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <div class="border-l-4 border-yellow-500 pl-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Surat Permohonan Cuti</p>
                            <p class="text-sm text-gray-600">Dari: John Doe</p>
                            <p class="text-xs text-gray-500">3 jam yang lalu</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Setujui</button>
                            <button class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">Tolak</button>
                        </div>
                    </div>
                </div>
                <div class="border-l-4 border-yellow-500 pl-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Surat Undangan Rapat</p>
                            <p class="text-sm text-gray-600">Dari: Jane Smith</p>
                            <p class="text-xs text-gray-500">1 hari yang lalu</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Setujui</button>
                            <button class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">Tolak</button>
                        </div>
                    </div>
                </div>
                <div class="border-l-4 border-yellow-500 pl-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Surat Pemberitahuan</p>
                            <p class="text-sm text-gray-600">Dari: Bob Wilson</p>
                            <p class="text-xs text-gray-500">2 hari yang lalu</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Setujui</button>
                            <button class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">Tolak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Grafik Surat Bulanan</h2>
        <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
            <p class="text-gray-500">Grafik akan ditampilkan di sini dengan Chart.js atau library lainnya</p>
        </div>
    </div>
</div>

@endsection