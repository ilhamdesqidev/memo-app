<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agro Wisata Gunung Mas - Wisata Alam & Edukasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9f4',
                            100: '#dcf2e3',
                            200: '#bbe5cb',
                            300: '#89d0a8',
                            400: '#52b67e',
                            500: '#2d9c5e',
                            600: '#1f7d4a',
                            700: '#1a643c',
                            800: '#175032',
                            900: '#14422a',
                        },
                        secondary: {
                            50: '#fefce8',
                            100: '#fef9c3',
                            200: '#fef08a',
                            300: '#fde047',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        }
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                        'fade-in-down': 'fadeInDown 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeInDown: {
                            '0%': { opacity: '0', transform: 'translateY(-30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideInRight: {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-poppins bg-gradient-to-br from-primary-50 to-secondary-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-lg border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-9 3 9-3-2-3 2zm0 0l-3-9h3m3 9h3l-3-9M5 12h14"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-primary-800">Agro Wisata</h1>
                        <p class="text-xs text-primary-600">Gunung Mas</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('login') }}" class="bg-primary-600 text-white px-6 py-2 rounded-full hover:bg-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl">Login</a>                    
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-primary-700 hover:text-primary-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden hidden bg-white/95 backdrop-blur-md border-t border-primary-100">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#home" class="block px-3 py-2 text-primary-700 hover:text-primary-500 font-medium">Beranda</a>
                <a href="#about" class="block px-3 py-2 text-primary-700 hover:text-primary-500 font-medium">Tentang</a>
                <a href="#facilities" class="block px-3 py-2 text-primary-700 hover:text-primary-500 font-medium">Fasilitas</a>
                <a href="#gallery" class="block px-3 py-2 text-primary-700 hover:text-primary-500 font-medium">Galeri</a>
                <a href="#contact" class="block px-3 py-2 text-primary-700 hover:text-primary-500 font-medium">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-16">
        <!-- Background with gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600/20 via-primary-500/10 to-secondary-400/20"></div>
        
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary-300/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary-300/20 rounded-full blur-3xl animate-float" style="animation-delay: -1.5s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-center lg:text-left animate-fade-in-up">
                    <h1 class="text-4xl md:text-6xl font-bold text-primary-800 mb-6 leading-tight">
                        Selamat Datang di
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-500">
                            Agro Wisata Gunung Mas
                        </span>
                    </h1>
                    <p class="text-lg md:text-xl text-primary-700 mb-8 leading-relaxed">
                        Nikmati keindahan alam, wisata edukasi pertanian, dan pengalaman tak terlupakan di kaki Gunung Mas. Tempat sempurna untuk keluarga dan pendidikan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <button class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-8 py-4 rounded-full font-semibold hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Jelajahi Sekarang
                        </button>
                        <button class="border-2 border-primary-600 text-primary-600 px-8 py-4 rounded-full font-semibold hover:bg-primary-600 hover:text-white transition-all duration-300">
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                </div>

                <!-- Hero Image/Illustration -->
                <div class="relative animate-slide-in-right">
                    <div class="w-full h-96 bg-gradient-to-br from-primary-200 to-secondary-200 rounded-3xl shadow-2xl overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-primary-400/30 to-secondary-400/30 flex items-center justify-center">
                            <!-- Placeholder for actual image -->
                            <div class="text-center">
                                <svg class="w-24 h-24 text-primary-600 mx-auto mb-4 animate-pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-9 3 9-3-2-3 2zm0 0l-3-9h3m3 9h3l-3-9M5 12h14"></path>
                                </svg>
                                <p class="text-primary-700 font-medium">Foto Agro Wisata</p>
                            </div>
                        </div>
                    </div>
                    <!-- Floating elements -->
                    <div class="absolute -top-4 -right-4 w-16 h-16 bg-secondary-400 rounded-full opacity-70 animate-float"></div>
                    <div class="absolute -bottom-6 -left-6 w-20 h-20 bg-primary-400 rounded-full opacity-60 animate-float" style="animation-delay: -2s;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-800 mb-4">Tentang Agro Wisata Gunung Mas</h2>
                <p class="text-lg text-primary-600 max-w-3xl mx-auto">
                    Destinasi wisata edukasi yang menggabungkan keindahan alam dengan pembelajaran pertanian modern
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-800 mb-2">Wisata Alam</h3>
                    <p class="text-primary-600">Nikmati udara segar dan pemandangan hijau yang menyejukkan mata</p>
                </div>

                <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-secondary-50 to-secondary-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-800 mb-2">Edukasi</h3>
                    <p class="text-primary-600">Pelajari teknik pertanian modern dan tradisional secara langsung</p>
                </div>

                <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-primary-50 to-secondary-50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-800 mb-2">Keluarga</h3>
                    <p class="text-primary-600">Aktivitas seru untuk seluruh anggota keluarga dari anak hingga dewasa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section id="facilities" class="py-20 bg-gradient-to-br from-primary-50/50 to-secondary-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-800 mb-4">Fasilitas Unggulan</h2>
                <p class="text-lg text-primary-600 max-w-3xl mx-auto">
                    Berbagai fasilitas modern dan nyaman untuk pengalaman wisata yang tak terlupakan
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Greenhouse</h3>
                    <p class="text-primary-600 text-sm">Rumah kaca modern dengan tanaman hidroponik</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-secondary-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Agro Market</h3>
                    <p class="text-primary-600 text-sm">Pasar hasil pertanian segar langsung dari kebun</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11M20 10v11"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Learning Center</h3>
                    <p class="text-primary-600 text-sm">Pusat pembelajaran dan workshop pertanian</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-secondary-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Restaurant</h3>
                    <p class="text-primary-600 text-sm">Restoran dengan menu masakan khas daerah</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-800 mb-4">Galeri Foto</h2>
                <p class="text-lg text-primary-600 max-w-3xl mx-auto">
                    Lihat keindahan dan aktivitas menarik di Agro Wisata Gunung Mas
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="aspect-square bg-gradient-to-br from-primary-200 to-primary-300 rounded-2xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-primary-700 font-medium">Foto 1</span>
                    </div>
                </div>
                <div class="aspect-square bg-gradient-to-br from-secondary-200 to-secondary-300 rounded-2xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-secondary-700 font-medium">Foto 2</span>
                    </div>
                </div>
                <div class="aspect-square bg-gradient-to-br from-primary-200 to-secondary-200 rounded-2xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-primary-700 font-medium">Foto 3</span>
                    </div>
                </div>
                <div class="aspect-square bg-gradient-to-br from-secondary-300 to-primary-300 rounded-2xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-primary-700 font-medium">Foto 4</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gradient-to-br from-primary-600 to-primary-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Hubungi Kami</h2>
                <p class="text-lg text-primary-100 max-w-3xl mx-auto">
                    Siap merencanakan kunjungan Anda? Hubungi kami untuk informasi lebih lanjut
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Alamat</h3>
                            <p class="text-primary-100">Jl. Gunung Mas No. 123, Kecamatan Cisarua, Kabupaten Bogor, Jawa Barat 16750</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Telepon</h3>
                            <p class="text-primary-100">+62 251 123 4567</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Email</h3>
                            <p class="text-primary-100">info@agrowisatagm.com</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8">
                    <h3 class="text-2xl font-semibold text-white mb-6">Kirim Pesan</h3>
                    <form class="space-y-4">
                        <div>
                            <input type="text" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                        </div>
                        <div>
                            <input type="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                        </div>
                        <div>
                            <input type="tel" placeholder="Nomor Telepon" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                        </div>
                        <div>
                            <textarea rows="4" placeholder="Pesan Anda" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-primary-50 transition-colors duration-300">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-9 3 9-3-2-3 2zm0 0l-3-9h3m3 9h3l-3-9M5 12h14"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Agro Wisata Gunung Mas</h3>
                            <p class="text-primary-300 text-sm">Wisata Alam & Edukasi</p>
                        </div>
                    </div>
                    <p class="text-primary-200 mb-4 leading-relaxed">
                        Destinasi wisata edukasi terbaik yang menggabungkan keindahan alam dengan pembelajaran pertanian modern. Cocok untuk keluarga, sekolah, dan komunitas.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.346-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-primary-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.05 0C5.4 0 0 5.4 0 12.05c0 6.65 5.4 12.05 12.05 12.05s12.05-5.4 12.05-12.05C24.1 5.4 18.7 0 12.05 0zM8.9 18.9h-2.7v-8.8h2.7v8.8zm-1.35-10c-.85 0-1.55-.7-1.55-1.55s.7-1.55 1.55-1.55 1.55.7 1.55 1.55-.7 1.55-1.55 1.55zm11.1 10h-2.7v-4.25c0-1.02-.02-2.33-1.42-2.33-1.42 0-1.64 1.11-1.64 2.26v4.32h-2.7v-8.8h2.6v1.2h.04c.36-.68 1.24-1.4 2.56-1.4 2.74 0 3.25 1.8 3.25 4.14v4.86z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Menu Utama</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-primary-200 hover:text-white transition-colors duration-300">Beranda</a></li>
                        <li><a href="#about" class="text-primary-200 hover:text-white transition-colors duration-300">Tentang Kami</a></li>
                        <li><a href="#facilities" class="text-primary-200 hover:text-white transition-colors duration-300">Fasilitas</a></li>
                        <li><a href="#gallery" class="text-primary-200 hover:text-white transition-colors duration-300">Galeri</a></li>
                        <li><a href="#contact" class="text-primary-200 hover:text-white transition-colors duration-300">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Jam Operasional</h4>
                    <div class="space-y-2 text-primary-200">
                        <p>Senin - Jumat: 08.00 - 17.00</p>
                        <p>Sabtu - Minggu: 07.00 - 18.00</p>
                        <p>Hari Libur: 07.00 - 18.00</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-primary-700 mt-8 pt-8 text-center">
                <p class="text-primary-200">
                    &copy; 2025 Agro Wisata Gunung Mas. Seluruh hak cipta dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white/95');
                navbar.classList.remove('bg-white/90');
            } else {
                navbar.classList.add('bg-white/90');
                navbar.classList.remove('bg-white/95');
            }
        });

        // Form submission (placeholder)
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Terima kasih! Pesan Anda telah dikirim. Kami akan segera menghubungi Anda.');
            this.reset();
        });

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe all sections for animations
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>