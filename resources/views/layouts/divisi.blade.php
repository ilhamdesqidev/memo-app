@php
    $user = auth()->user();
    $divisiNama = $user->divisi->nama ?? 'Unknown';
    $prefix = explode('.', Route::currentRouteName())[0] . '.'; // Contoh: 'pengembangan.'
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard {{ $divisiNama }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold">Divisi</h2>
            <p class="text-sm text-gray-600">{{ $divisiNama }}</p>
        </div>

        <ul class="py-4">
            <li>
                <a href="{{ route($prefix . 'dashboard') }}" class="block px-4 py-2 hover:bg-gray-200">Dashboard</a>
            </li>
            <li>
                <a href="{{ route($prefix . 'memo.index') }}" class="block px-4 py-2 hover:bg-gray-200">Daftar Memo</a>
            </li>
            {{-- Tambahan fitur per divisi --}}
            @switch($divisiNama)
                @case('Pengembangan Bisnis')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Proyek Bisnis</a></li>
                    @break
                @case('Manager')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Laporan Staff</a></li>
                    @break
                @case('Operasional Wilayah I')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Wilayah I Ops</a></li>
                    @break
                @case('Operasional Wilayah II')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Wilayah II Ops</a></li>
                    @break
                @case('Umum dan Legal')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Arsip Hukum</a></li>
                    @break
                @case('Administrasi dan Keuangan')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Transaksi Keuangan</a></li>
                    @break
                @case('Infrastruktur dan Sipil')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Proyek Sipil</a></li>
                    @break
                @case('Food Beverage')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Manajemen Menu</a></li>
                    @break
                @case('Marketing dan Sales')
                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Target Penjualan</a></li>
                    @break
            @endswitch

            <li><a href="{{ route('profil.index') }}" class="block px-4 py-2 hover:bg-gray-200">Profil</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">Logout</button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</body>
</html>
