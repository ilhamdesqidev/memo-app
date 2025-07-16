@php
    $user = auth()->user();
    $divisiNama = $user->divisi->nama ?? 'Unknown';
    
    // Define prefix based on user's division
    $prefix = match($divisiNama) {
        'Pengembangan Bisnis' => 'pengembangan.',
        'Manager' => 'manager.',
        'Operasional Wilayah I' => 'opwil1.',
        'Operasional Wilayah II' => 'opwil2.',
        'Umum dan Legal' => 'umumlegal.',
        'Administrasi dan Keuangan' => 'adminkeu.',
        'Infrastruktur dan Sipil' => 'sipil.',
        'Food Beverage' => 'food.',
        'Marketing dan Sales' => 'marketing.',
        default => 'profil.'
    };
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ $divisiNama }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dropdown-content {
            display: none;
            transition: all 0.3s ease;
        }
        .dropdown.active .dropdown-content {
            display: block;
        }
        .dropdown.active .dropdown-chevron {
            transform: rotate(180deg);
        }
        .sidebar {
            transition: width 0.3s ease;
        }
        .sidebar.collapsed {
            width: 4rem;
        }
        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            pointer-events: none;
        }
        .sidebar.collapsed .dropdown-content {
            display: none !important;
        }
        .sidebar.collapsed .dropdown-chevron {
            opacity: 0;
        }
        .sidebar-text {
            transition: opacity 0.3s ease;
        }
        .toggle-btn {
            transition: transform 0.3s ease;
        }
        .sidebar.collapsed .toggle-btn {
            transform: rotate(180deg);
        }
        .sidebar.collapsed .nav-item {
            justify-content: center;
        }
        .sidebar.collapsed .nav-item svg {
            margin-right: 0;
        }
        .tooltip {
            position: relative;
        }
        .tooltip .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: #374151;
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 5px 8px;
            position: fixed;
            z-index: 9999;
            left: 4.5rem;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
            pointer-events: none;
            white-space: nowrap;
        }
        .tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            margin-top: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent #374151 transparent transparent;
        }
        .sidebar.collapsed .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .user-dropdown-content {
            bottom: 100%;
            margin-bottom: 8px;
        }
        /* Responsive Header Styles */
        .header-section {
            transition: all 0.3s ease;
        }
        .sidebar.collapsed .header-section {
            padding: 1rem 0.5rem;
            text-align: center;
        }
        .sidebar.collapsed .header-content {
            display: none;
        }
        .sidebar.collapsed .header-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .header-logo {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-radius: 8px;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .sidebar:not(.collapsed) .header-logo {
            display: flex;
        }
        .sidebar.collapsed .header-logo {
            display: flex;
            margin-right: 0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="sidebar flex flex-col w-64 bg-indigo-800 relative">
                <!-- Toggle Button -->
                <button class="toggle-btn absolute -right-3 top-6 bg-indigo-600 text-white p-1 rounded-full shadow-lg hover:bg-indigo-700 z-10 transition-colors duration-200" onclick="toggleSidebar()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <!-- Divisi Info Section -->
                <div class="header-section p-4 border-b border-indigo-700 tooltip">
                    <div class="flex items-center ml-2">
                        <div class="header-logo">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 5.16-1.26 9-5.45 9-11V7l-10-5z"/>
                            </svg>
                        </div>
                        <div class="header-content">
                            <h2 class="text-xl font-bold text-white">Mestakara</h2>
                            <p class="text-sm text-indigo-300">Agro gunung mas</p>
                        </div>
                    </div>
                    <span class="tooltip-text">Mestakara - Agro gunung mas</span>
                </div>
               
                <div class="flex flex-col flex-grow pt-5 overflow-y-auto">
                    <div class="flex flex-col flex-1 px-4 space-y-1">
                        <!-- Dashboard -->
                        <div class="tooltip">
                            <a href="{{ route($prefix . 'dashboard') }}" class="nav-item @if(request()->routeIs($prefix . 'dashboard')) bg-indigo-900 @endif flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="sidebar-text">Dashboard</span>
                            </a>
                            <span class="tooltip-text">Dashboard</span>
                        </div>

                        <!-- Memo Dropdown -->
                        <div class="dropdown tooltip mb-2 @if(request()->routeIs($prefix . 'memo.*')) active @endif">
                            <button class="dropdown-toggle nav-item flex items-center justify-between w-full px-4 py-2 text-left text-white rounded-lg hover:bg-indigo-700">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="sidebar-text">Memo</span>
                                </div>
                                <svg class="dropdown-chevron sidebar-text w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div class="dropdown-content ml-8 mt-1 space-y-1">
                                <a href="{{ route($prefix . 'memo.index') }}" class="@if(request()->routeIs($prefix . 'memo.index')) bg-indigo-900 @endif flex items-center px-4 py-2 text-sm text-white rounded-lg hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    Daftar Memo
                                </a>
                            </div>
                            <span class="tooltip-text">Memo</span>
                        </div>

                        <!-- Divisi Specific Features -->
                        @switch($divisiNama)
                            @case('Pengembangan Bisnis')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="sidebar-text">Proyek Bisnis</span>
                                    </a>
                                    <span class="tooltip-text">Proyek Bisnis</span>
                                </div>
                                @break
                            @case('Manager')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="sidebar-text">Arsip</span>
                                    </a>
                                    <span class="tooltip-text">Arsip</span>
                                </div>
                                @break
                            @case('Operasional Wilayah I')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="sidebar-text">Wilayah I Ops</span>
                                    </a>
                                    <span class="tooltip-text">Wilayah I Ops</span>
                                </div>
                                @break
                            @case('Operasional Wilayah II')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="sidebar-text">Wilayah II Ops</span>
                                    </a>
                                    <span class="tooltip-text">Wilayah II Ops</span>
                                </div>
                                @break
                            @case('Umum dan Legal')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="sidebar-text">Arsip Hukum</span>
                                    </a>
                                    <span class="tooltip-text">Arsip Hukum</span>
                                </div>
                                @break
                            @case('Administrasi dan Keuangan')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="sidebar-text">Transaksi Keuangan</span>
                                    </a>
                                    <span class="tooltip-text">Transaksi Keuangan</span>
                                </div>
                                @break
                            @case('Infrastruktur dan Sipil')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="sidebar-text">Proyek Sipil</span>
                                    </a>
                                    <span class="tooltip-text">Proyek Sipil</span>
                                </div>
                                @break
                            @case('Food Beverage')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m-8-13v13m16 0V8M4 8l8-4 8 4"></path>
                                        </svg>
                                        <span class="sidebar-text">Manajemen Menu</span>
                                    </a>
                                    <span class="tooltip-text">Manajemen Menu</span>
                                </div>
                                @break
                            @case('Marketing dan Sales')
                                <div class="tooltip">
                                    <a href="#" class="nav-item flex items-center px-4 py-2 text-white rounded-lg hover:bg-indigo-700">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span class="sidebar-text">Target Penjualan</span>
                                    </a>
                                    <span class="tooltip-text">Target Penjualan</span>
                                </div>
                                @break
                        @endswitch
                    </div>

                    <!-- User Profil Section -->
                    <div class="mt-auto mb-4 px-4">
                        <div class="dropdown tooltip relative">
                            <button class="dropdown-toggle nav-item flex items-center justify-between w-full px-4 py-2 text-left text-white rounded-lg hover:bg-indigo-700 bg-indigo-900">
                                <div class="flex items-center">
                                    <div class="user-avatar">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="sidebar-text">
                                        <div class="flex items-center">
                                            <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                                            @if(Auth::user()->divisi)
                                                <span class="ml-2 px-2 py-0.5 text-xs bg-indigo-600 rounded-full">
                                                    {{ getInitials(Auth::user()->divisi->nama) }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-indigo-300">{{ Auth::user()->username }}</div>
                                    </div>
                                </div>
                                <svg class="dropdown-chevron sidebar-text w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div class="dropdown-content user-dropdown-content absolute left-0 right-0 bg-indigo-900 rounded-lg shadow-lg border border-indigo-700 mx-2 mb-2">
                           <a href="{{ route('profil.index') }}" class="flex items-center px-4 py-2 text-sm text-white hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </a>
                                
                                <div class="border-t border-indigo-700"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-white hover:bg-red-600 rounded-b-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                            <span class="tooltip-text">User Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
            
            // Update icon visibility
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            
            if (sidebar.classList.contains('collapsed')) {
                sidebarTexts.forEach(text => text.style.display = 'none');
            } else {
                sidebarTexts.forEach(text => text.style.display = 'inline');
            }
            
            // Update tooltip positions
            updateTooltipPositions();
        }

        function updateTooltipPositions() {
            const tooltips = document.querySelectorAll('.tooltip-text');
            tooltips.forEach(tooltip => {
                const rect = tooltip.closest('.tooltip').getBoundingClientRect();
                tooltip.style.top = (rect.top + rect.height / 2) + 'px';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const dropdown = this.closest('.dropdown');
                    const sidebar = document.querySelector('.sidebar');
                    
                    // Don't allow dropdown to open if sidebar is collapsed
                    if (!sidebar.classList.contains('collapsed')) {
                        dropdown.classList.toggle('active');
                    }
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown').forEach(dropdown => {
                        dropdown.classList.remove('active');
                    });
                }
            });
        });
    </script>
</body>
</html>