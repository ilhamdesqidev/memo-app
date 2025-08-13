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
                        'playfair': ['Playfair Display', 'serif'],
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="font-poppins bg-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-9 3 9-3-2-3 2zm0 0l-3-9h3m3 9h3l-3-9M5 12h14"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-primary-800 font-playfair">Mestakara</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-primary-800 hover:text-secondary-500 transition-colors duration-300 font-medium">BERANDA</a>
                    <a href="#about" class="text-primary-800 hover:text-secondary-500 transition-colors duration-300 font-medium">TENTANG</a>
                    <a href="#facilities" class="text-primary-800 hover:text-secondary-500 transition-colors duration-300 font-medium">FASILITAS</a>
                    <a href="#gallery" class="text-primary-800 hover:text-secondary-500 transition-colors duration-300 font-medium">GALERI</a>
                    <a href="#contact" class="text-primary-800 hover:text-secondary-500 transition-colors duration-300 font-medium">KONTAK</a>
                </div>

                <!-- Login Button -->
                <div class="hidden md:block">
                    <a href="{{ route('login') }}" class="bg-secondary-500 hover:bg-secondary-600 text-white font-semibold px-6 py-2 rounded-full text-sm tracking-wide transition-all duration-300 transform hover:scale-105">
                        LOGIN
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-primary-800 hover:text-secondary-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#home" class="block px-3 py-2 text-primary-800 hover:text-secondary-500 font-medium">BERANDA</a>
                <a href="#about" class="block px-3 py-2 text-primary-800 hover:text-secondary-500 font-medium">TENTANG</a>
                <a href="#facilities" class="block px-3 py-2 text-primary-800 hover:text-secondary-500 font-medium">FASILITAS</a>
                <a href="#gallery" class="block px-3 py-2 text-primary-800 hover:text-secondary-500 font-medium">GALERI</a>
                <a href="#contact" class="block px-3 py-2 text-primary-800 hover:text-secondary-500 font-medium">KONTAK</a>
                <a href="#" class="block px-3 py-2 text-primary-800 hover:text-secondary-500 font-medium">LOGIN</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Slider -->
    <section id="home" class="relative min-h-screen flex items-center justify-center bg-gray-100 overflow-hidden pt-16">
        <!-- Slider Container -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Slide 1 -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100" id="slide1">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
                <div class="absolute inset-0 bg-black/40"></div>
            </div>
            
            <!-- Slide 2 -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" id="slide2">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
                <div class="absolute inset-0 bg-black/40"></div>
            </div>
            
            <!-- Slide 3 -->
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" id="slide3">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1566438480900-0609be27a4be?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
                <div class="absolute inset-0 bg-black/40"></div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 text-center max-w-4xl mx-auto px-6 py-20">
            <!-- Welcome Text -->
            <div class="mb-8">
                <p class="text-secondary-400 font-playfair text-lg md:text-xl tracking-wider mb-4 animate-fade-in-down" style="font-style: italic;">
                    Selamat Datang di
                </p>
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 font-playfair tracking-wide animate-fade-in-up">
                    AGRO WISATA
                    <span class="block text-4xl md:text-6xl text-secondary-400 mt-2">
                        GUNUNG MAS
                    </span>
                </h1>
            </div>

            <!-- Tagline -->
            <div class="mb-12">
                <p class="text-xl md:text-2xl text-gray-200 leading-relaxed font-light animate-slide-in-right" id="slide-text">
                    Nikmati keindahan alam, wisata edukasi pertanian modern, dan pengalaman tak terlupakan di kaki Gunung Mas
                </p>
            </div>

            <!-- CTA Button -->
            <div class="animate-fade-in-up" style="animation-delay: 1s;">
                <a href="{{ route('login') }}" class="inline-block bg-secondary-500 hover:bg-secondary-600 text-white font-semibold px-10 py-4 rounded-full text-lg tracking-wide transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    LOGIN
                    <svg class="inline-block ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Navigation dots -->
        <div class="absolute bottom-8 right-8 flex space-x-2 z-10">
            <div class="w-3 h-3 bg-secondary-500 rounded-full cursor-pointer dot active" data-slide="1"></div>
            <div class="w-3 h-3 bg-white/50 rounded-full cursor-pointer dot" data-slide="2"></div>
            <div class="w-3 h-3 bg-white/50 rounded-full cursor-pointer dot" data-slide="3"></div>
        </div>

        <!-- Left/Right navigation arrows -->
        <button class="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all duration-300 backdrop-blur-sm z-10" id="prev-slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button class="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all duration-300 backdrop-blur-sm z-10" id="next-slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-800 mb-4 font-playfair">Tentang Kami</h2>
                <div class="w-20 h-1 bg-secondary-500 mx-auto mb-6"></div>
                <p class="text-lg text-primary-600 max-w-3xl mx-auto">
                    Destinasi wisata edukasi yang menggabungkan keindahan alam dengan pembelajaran pertanian modern
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-8 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mountain text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-800 mb-2">Wisata Alam</h3>
                    <p class="text-primary-600">Nikmati udara segar dan pemandangan hijau yang menyejukkan mata</p>
                </div>

                <div class="text-center p-8 rounded-xl bg-gradient-to-br from-secondary-50 to-secondary-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-800 mb-2">Edukasi</h3>
                    <p class="text-primary-600">Pelajari teknik pertanian modern dan tradisional secara langsung</p>
                </div>

                <div class="text-center p-8 rounded-xl bg-gradient-to-br from-primary-50 to-secondary-50 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-primary-800 mb-2">Keluarga</h3>
                    <p class="text-primary-600">Aktivitas seru untuk seluruh anggota keluarga dari anak hingga dewasa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section id="facilities" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-800 mb-4 font-playfair">Fasilitas Kami</h2>
                <div class="w-20 h-1 bg-secondary-500 mx-auto mb-6"></div>
                <p class="text-lg text-primary-600 max-w-3xl mx-auto">
                    Berbagai fasilitas modern dan nyaman untuk pengalaman wisata yang tak terlupakan
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary-600 transition-colors duration-300">
                        <i class="fas fa-leaf text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Greenhouse</h3>
                    <p class="text-primary-600 text-sm">Rumah kaca modern dengan tanaman hidroponik</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-secondary-500 rounded-lg flex items-center justify-center mb-4 group-hover:bg-secondary-600 transition-colors duration-300">
                        <i class="fas fa-shopping-basket text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Agro Market</h3>
                    <p class="text-primary-600 text-sm">Pasar hasil pertanian segar langsung dari kebun</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary-600 transition-colors duration-300">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Learning Center</h3>
                    <p class="text-primary-600 text-sm">Pusat pembelajaran dan workshop pertanian</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="w-12 h-12 bg-secondary-500 rounded-lg flex items-center justify-center mb-4 group-hover:bg-secondary-600 transition-colors duration-300">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-primary-800 mb-2">Restaurant</h3>
                    <p class="text-primary-600 text-sm">Restoran dengan menu masakan khas daerah</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-800 mb-4 font-playfair">Galeri Foto</h2>
                <div class="w-20 h-1 bg-secondary-500 mx-auto mb-6"></div>
                <p class="text-lg text-primary-600 max-w-3xl mx-auto">
                    Lihat keindahan dan aktivitas menarik di Agro Wisata Gunung Mas
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="aspect-square bg-gradient-to-br from-primary-200 to-primary-300 rounded-xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden group relative">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-primary-700 font-medium group-hover:scale-110 transition-transform duration-300">Greenhouse Tour</span>
                    </div>
                </div>
                <div class="aspect-square bg-gradient-to-br from-secondary-200 to-secondary-300 rounded-xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden group relative">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-secondary-700 font-medium group-hover:scale-110 transition-transform duration-300">Farm Activity</span>
                    </div>
                </div>
                <div class="aspect-square bg-gradient-to-br from-primary-200 to-secondary-200 rounded-xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden group relative">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-primary-700 font-medium group-hover:scale-110 transition-transform duration-300">Mountain View</span>
                    </div>
                </div>
                <div class="aspect-square bg-gradient-to-br from-secondary-300 to-primary-300 rounded-xl hover:scale-105 transition-transform duration-300 cursor-pointer overflow-hidden group relative">
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-primary-700 font-medium group-hover:scale-110 transition-transform duration-300">Family Fun</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-primary-700 text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 font-playfair">Hubungi Kami</h2>
                <div class="w-20 h-1 bg-secondary-400 mx-auto mb-6"></div>
                <p class="text-lg text-primary-100 max-w-3xl mx-auto">
                    Siap merencanakan kunjungan Anda? Hubungi kami untuk informasi lebih lanjut
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div class="space-y-8">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Alamat</h3>
                            <p class="text-primary-100 leading-relaxed">Jl. Gunung Mas No. 123, Kecamatan Cisarua,<br>Kabupaten Bogor, Jawa Barat 16750</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-phone-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Telepon</h3>
                            <p class="text-primary-100 text-lg">+62 251 123 4567</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Email</h3>
                            <p class="text-primary-100 text-lg">info@agrowisatagm.com</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Jam Operasional</h3>
                            <div class="text-primary-100 space-y-1">
                                <p>Senin - Jumat: 08.00 - 17.00</p>
                                <p>Sabtu - Minggu: 07.00 - 18.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20">
                    <h3 class="text-2xl font-semibold text-white mb-6 font-playfair">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <input type="text" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-secondary-400 focus:border-transparent">
                            </div>
                            <div>
                                <input type="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-secondary-400 focus:border-transparent">
                            </div>
                        </div>
                        <div>
                            <input type="tel" placeholder="Nomor Telepon" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-secondary-400 focus:border-transparent">
                        </div>
                        <div>
                            <textarea rows="4" placeholder="Pesan Anda" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-secondary-400 focus:border-transparent resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-secondary-500 hover:bg-secondary-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                            KIRIM PESAN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21l3-9 3 9-3-2-3 2zm0 0l-3-9h3m3 9h3l-3-9M5 12h14"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold font-playfair">Agro Wisata Gunung Mas</h3>
                            <p class="text-primary-300 text-sm tracking-wider">WISATA ALAM & EDUKASI</p>
                        </div>
                    </div>
                    <p class="text-primary-200 mb-6 leading-relaxed max-w-md">
                        Destinasi wisata edukasi terbaik yang menggabungkan keindahan alam dengan pembelajaran pertanian modern. Cocok untuk keluarga, sekolah, dan komunitas.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-secondary-500 transition-all duration-300">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-secondary-500 transition-all duration-300">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-secondary-500 transition-all duration-300">
                            <i class="fab fa-twitter text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center hover:bg-secondary-500 transition-all duration-300">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-6 font-playfair">Menu Utama</h4>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300 flex items-center"><span class="mr-2">→</span> Beranda</a></li>
                        <li><a href="#about" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300 flex items-center"><span class="mr-2">→</span> Tentang Kami</a></li>
                        <li><a href="#facilities" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300 flex items-center"><span class="mr-2">→</span> Fasilitas</a></li>
                        <li><a href="#gallery" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300 flex items-center"><span class="mr-2">→</span> Galeri</a></li>
                        <li><a href="#contact" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300 flex items-center"><span class="mr-2">→</span> Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-6 font-playfair">Kontak Kami</h4>
                    <div class="space-y-4 text-primary-300">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt text-secondary-400 text-sm"></i>
                            <span class="text-sm">Puncak, Bogor</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-phone-alt text-secondary-400 text-sm"></i>
                            <span class="text-sm">+62 251 123 4567</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-secondary-400 text-sm"></i>
                            <span class="text-sm">info@agrowisatagm.com</span>
                        </div>
                        <div class="pt-2 border-t border-primary-700">
                            <p class="text-xs text-primary-400">Buka Setiap Hari</p>
                            <p class="text-sm">07:00 - 18:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-primary-700 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-primary-300 text-sm mb-4 md:mb-0">
                        &copy; 2025 Agro Wisata Gunung Mas. All rights reserved.
                    </p>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300">Kebijakan Privasi</a>
                        <a href="#" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300">Syarat & Ketentuan</a>
                        <a href="#" class="text-primary-300 hover:text-secondary-400 transition-colors duration-300">Peta Situs</a>
                    </div>
                </div>
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

        // Form submission with enhanced feedback
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>MENGIRIM...';
            submitBtn.disabled = true;
            
            // Simulate form submission
            setTimeout(() => {
                alert('✅ Terima kasih! Pesan Anda telah dikirim.\nTim kami akan segera menghubungi Anda.');
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        // Image Slider Functionality
        let currentSlide = 1;
        const totalSlides = 3;
        const slideTexts = [
            "Nikmati keindahan alam, wisata edukasi pertanian modern, dan pengalaman tak terlupakan di kaki Gunung Mas",
            "Pelajari teknologi pertanian terdepan dengan sistem hidroponik canggih di fasilitas greenhouse kami",
            "Aktivitas seru dan mendidik untuk seluruh anggota keluarga dalam suasana alam yang asri"
        ];

        function showSlide(n) {
            // Hide all slides
            for (let i = 1; i <= totalSlides; i++) {
                document.getElementById(`slide${i}`).classList.remove('opacity-100');
                document.getElementById(`slide${i}`).classList.add('opacity-0');
            }
            
            // Show selected slide
            document.getElementById(`slide${n}`).classList.remove('opacity-0');
            document.getElementById(`slide${n}`).classList.add('opacity-100');
            
            // Update slide text
            document.getElementById('slide-text').textContent = slideTexts[n-1];
            
            // Update dots
            document.querySelectorAll('.dot').forEach(dot => {
                dot.classList.remove('bg-secondary-500');
                dot.classList.add('bg-white/50');
            });
            document.querySelector(`.dot[data-slide="${n}"]`).classList.remove('bg-white/50');
            document.querySelector(`.dot[data-slide="${n}"]`).classList.add('bg-secondary-500');
            
            currentSlide = n;
        }

        // Next slide
        document.getElementById('next-slide').addEventListener('click', () => {
            currentSlide = currentSlide === totalSlides ? 1 : currentSlide + 1;
            showSlide(currentSlide);
        });

        // Previous slide
        document.getElementById('prev-slide').addEventListener('click', () => {
            currentSlide = currentSlide === 1 ? totalSlides : currentSlide - 1;
            showSlide(currentSlide);
        });

        // Dot navigation
        document.querySelectorAll('.dot').forEach(dot => {
            dot.addEventListener('click', () => {
                const slideNumber = parseInt(dot.getAttribute('data-slide'));
                showSlide(slideNumber);
            });
        });

        // Auto slide change every 5 seconds
        setInterval(() => {
            currentSlide = currentSlide === totalSlides ? 1 : currentSlide + 1;
            showSlide(currentSlide);
        }, 5000);

        // Initialize first slide
        showSlide(1);
    </script>
</body>
</html>