@extends('layouts.divisi')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<div class="max-w-[1600px] mx-auto p-6 font-sans grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-700 text-white px-8 py-8 col-span-1 lg:col-span-2 rounded-xl shadow-lg border-l-4 border-blue-400">
        <h1 class="text-3xl sm:text-4xl font-bold mb-2 tracking-tight">DASHBOARD OPERASIONAL WILAYAH</h1>
        <p class="text-blue-100 text-base flex items-center gap-2">
            <i class="fas fa-clock text-blue-300"></i>
            Selamat datang kembali. Terakhir login: 05 Jun 2024, 09:45
        </p>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col gap-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Pending Card -->
        <div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm transition-all duration-300 hover:shadow-lg hover:border-yellow-400 hover:-translate-y-1 group">
            <div class="flex justify-between items-center mb-6">
                <div class="w-12 h-12 flex items-center justify-center text-white bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                    <i class="fas fa-clock text-lg"></i>
                </div>
                <div class="text-xs font-semibold px-3 py-1.5 min-w-[70px] text-green-700 bg-green-100 rounded-full border border-green-300 text-center">
                    <i class="fas fa-arrow-up"></i> +12%
                </div>
            </div>
            <div class="text-4xl font-bold text-gray-800 mb-2">15</div>
            <div class="text-sm text-gray-600 font-medium uppercase tracking-wide">MENUNGGU</div>
        </div>

        <!-- Approved Card -->
        <div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm transition-all duration-300 hover:shadow-lg hover:border-green-400 hover:-translate-y-1 group">
            <div class="flex justify-between items-center mb-6">
                <div class="w-12 h-12 flex items-center justify-center text-white bg-gradient-to-br from-green-400 to-green-500 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                    <i class="fas fa-check text-lg"></i>
                </div>
                <div class="text-xs font-semibold px-3 py-1.5 min-w-[70px] text-green-700 bg-green-100 rounded-full border border-green-300 text-center">
                    <i class="fas fa-arrow-up"></i> +8%
                </div>
            </div>
            <div class="text-4xl font-bold text-gray-800 mb-2">42</div>
            <div class="text-sm text-gray-600 font-medium uppercase tracking-wide">DISETUJUI</div>
        </div>

        <!-- Rejected Card -->
        <div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm transition-all duration-300 hover:shadow-lg hover:border-red-400 hover:-translate-y-1 group">
            <div class="flex justify-between items-center mb-6">
                <div class="w-12 h-12 flex items-center justify-center text-white bg-gradient-to-br from-red-400 to-red-500 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                    <i class="fas fa-times text-lg"></i>
                </div>
                <div class="text-xs font-semibold px-3 py-1.5 min-w-[70px] text-red-700 bg-red-100 rounded-full border border-red-300 text-center">
                    <i class="fas fa-arrow-down"></i> -3%
                </div>
            </div>
            <div class="text-4xl font-bold text-gray-800 mb-2">5</div>
            <div class="text-sm text-gray-600 font-medium uppercase tracking-wide">DITOLAK</div>
        </div>

        <!-- Submission Card -->
        <div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm transition-all duration-300 hover:shadow-lg hover:border-blue-400 hover:-translate-y-1 group">
            <div class="flex justify-between items-center mb-6">
                <div class="w-12 h-12 flex items-center justify-center text-white bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                    <i class="fas fa-wallet text-lg"></i>
                </div>
                <div class="text-xs font-semibold px-3 py-1.5 min-w-[70px] text-green-700 bg-green-100 rounded-full border border-green-300 text-center">
                    <i class="fas fa-arrow-up"></i> +5%
                </div>
            </div>
            <div class="text-4xl font-bold text-gray-800 mb-2">28</div>
            <div class="text-sm text-gray-600 font-medium uppercase tracking-wide">PENGAJUAN</div>
        </div>
        </div>

    <!-- Activity Section -->
<div class="bg-white p-8 border border-gray-200 rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b border-gray-200 flex items-center gap-3">
        <div class="w-8 h-8 flex items-center justify-center bg-blue-500 rounded-lg">
            <i class="fas fa-list text-white"></i>
        </div>
        AKTIVITAS TERAKHIR
    </h2>
    <div class="flex flex-col divide-y divide-gray-100">
        <!-- Activity Item 1 -->
        <div class="flex gap-4 py-5 hover:bg-gray-50 transition rounded-lg px-2">
            <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-full shadow-sm flex-shrink-0">
                <i class="fas fa-check"></i>
            </div>
            <div class="flex-1">
                <div class="text-gray-800 font-semibold mb-1">
                    Memo #2024-015 (Pengajuan dana proyek Q2) telah disetujui
                </div>
                <div class="text-sm text-gray-500 flex items-center gap-2">
                    <i class="far fa-clock text-gray-400"></i> 12:45 - 05 Jun 2024
                </div>
            </div>
        </div>

        <!-- Activity Item 2 -->
        <div class="flex gap-4 py-5 hover:bg-gray-50 transition rounded-lg px-2">
            <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-full shadow-sm flex-shrink-0">
                <i class="fas fa-exclamation"></i>
            </div>
            <div class="flex-1">
                <div class="text-gray-800 font-semibold mb-1">
                    Memo #2024-016 (Pembelian peralatan kantor) membutuhkan review Anda
                </div>
                <div class="text-sm text-gray-500 flex items-center gap-2">
                    <i class="far fa-clock text-gray-400"></i> 10:30 - 05 Jun 2024
                </div>
            </div>
        </div>

        <!-- Activity Item 3 -->
        <div class="flex gap-4 py-5 hover:bg-gray-50 transition rounded-lg px-2">
            <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-red-500 to-red-600 text-white rounded-full shadow-sm flex-shrink-0">
                <i class="fas fa-times"></i>
            </div>
            <div class="flex-1">
                <div class="text-gray-800 font-semibold mb-1">
                    Memo #2024-014 (Perjalanan dinas ke Bandung) ditolak - Melebihi budget
                </div>
                <div class="text-sm text-gray-500 flex items-center gap-2">
                    <i class="far fa-clock text-gray-400"></i> 09:15 - 05 Jun 2024
                </div>
            </div>
        </div>
    </div>
</div>
    </div>

    <!-- Sidebar -->
    <div class="flex flex-col gap-8">
        <!-- Quick Actions -->
        <div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-6 pb-3 border-b border-gray-200 flex items-center gap-3">
                <div class="w-8 h-8 flex items-center justify-center bg-yellow-500 rounded-lg">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                AKSI CEPAT
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="bg-white border border-gray-200 p-4 no-underline text-gray-800 flex flex-col items-center gap-3 transition-all duration-300 text-center rounded-lg hover:border-yellow-400 hover:bg-yellow-50 hover:shadow-md hover:-translate-y-1 group">
                    <div class="w-10 h-10 flex items-center justify-center text-white bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="font-semibold text-sm">Review Memo</div>
                </a>
                <a href="#" class="bg-white border border-gray-200 p-4 no-underline text-gray-800 flex flex-col items-center gap-3 transition-all duration-300 text-center rounded-lg hover:border-green-400 hover:bg-green-50 hover:shadow-md hover:-translate-y-1 group">
                    <div class="w-10 h-10 flex items-center justify-center text-white bg-gradient-to-br from-green-400 to-green-500 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="font-semibold text-sm">Buat Baru</div>
                </a>
                <a href="#" class="bg-white border border-gray-200 p-4 no-underline text-gray-800 flex flex-col items-center gap-3 transition-all duration-300 text-center rounded-lg hover:border-blue-400 hover:bg-blue-50 hover:shadow-md hover:-translate-y-1 group">
                    <div class="w-10 h-10 flex items-center justify-center text-white bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="font-semibold text-sm">Laporan</div>
                </a>
                <a href="#" class="bg-white border border-gray-200 p-4 no-underline text-gray-800 flex flex-col items-center gap-3 transition-all duration-300 text-center rounded-lg hover:border-blue-400 hover:bg-blue-50 hover:shadow-md hover:-translate-y-1 group">
                    <div class="w-10 h-10 flex items-center justify-center text-white bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="font-semibold text-sm">Cari Memo</div>
                </a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm h-full">
            <h2 class="text-xl font-bold text-gray-800 mb-6 pb-3 border-b border-gray-200 flex items-center gap-3">
                <div class="w-8 h-8 flex items-center justify-center bg-green-500 rounded-lg">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                STATISTIK
            </h2>
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 h-[280px] flex items-center justify-center text-gray-500 text-base rounded-xl border border-gray-200">
                <div class="text-center">
                    <i class="fas fa-chart-bar text-3xl text-gray-400 mb-3"></i>
                    <div class="font-medium">Grafik Statistik Memo Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection