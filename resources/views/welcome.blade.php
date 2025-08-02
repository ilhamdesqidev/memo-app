<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agro Wisata Gunung Mas - Loading</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9f4',100: '#dcf2e3',200: '#bbe5cb', 300:'#89d0a8',400: '#52b67e',500: '#2d9c5e',600: '#1f7d4a',700: '#1a643c',800: '#175032',900: '#14422a',
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
                        },
                        flower: {
                            pink: '#f472b6',
                            yellow: '#facc15',
                            purple: '#a855f7',
                            blue: '#60a5fa',
                            white: '#f9fafb'
                        }
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in',
                        'slide-in': 'slideIn 2s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'sway': 'sway 4s ease-in-out infinite',
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'scale-breath': 'scaleBreath 3s ease-in-out infinite',
                        'journey': 'journey 15s linear infinite',
                        'birds': 'birds 20s linear infinite',
                        'leaves': 'leaves 6s ease-in-out infinite',
                        'mountain-mist': 'mountainMist 5s ease-in-out infinite',
                        'sun-rays': 'sunRays 2s ease-in-out infinite',
                        'flower-sway': 'flowerSway 5s ease-in-out infinite alternate',
                        'bloom': 'bloom 2s ease-out forwards'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        sway: {
                            '0%, 100%': { transform: 'rotate(-2deg)' },
                            '50%': { transform: 'rotate(2deg)' }
                        },
                        flowerSway: {
                            '0%, 100%': { transform: 'translateX(-2px) rotate(-1deg)' },
                            '50%': { transform: 'translateX(2px) rotate(1deg)' }
                        },
                        scaleBreath: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' }
                        },
                        journey: {
                            '0%': { transform: 'translateX(-200px)' },
                            '100%': { transform: 'translateX(calc(100vw + 200px))' }
                        },
                        birds: {
                            '0%': { 
                                transform: 'translateX(-100px) translateY(0px)',
                                opacity: '0'
                            },
                            '5%': { opacity: '1' },
                            '95%': { opacity: '1' },
                            '100%': { 
                                transform: 'translateX(calc(100vw + 100px)) translateY(-20px)',
                                opacity: '0'
                            }
                        },
                        leaves: {
                            '0%': { transform: 'translateY(-5px) rotate(0deg)' },
                            '25%': { transform: 'translateY(5px) rotate(90deg)' },
                            '50%': { transform: 'translateY(10px) rotate(180deg)' },
                            '75%': { transform: 'translateY(5px) rotate(270deg)' },
                            '100%': { transform: 'translateY(-5px) rotate(360deg)' }
                        },
                        mountainMist: {
                            '0%, 100%': { opacity: '0.6', transform: 'translateX(0)' },
                            '50%': { opacity: '0.8', transform: 'translateX(10px)' }
                        },
                        sunRays: {
                            '0%, 100%': { transform: 'rotate(0deg) scale(1)', opacity: '0.7' },
                            '50%': { transform: 'rotate(180deg) scale(1.1)', opacity: '1' }
                        },
                        bloom: {
                            '0%': { transform: 'scale(0)', opacity: '0' },
                            '80%': { transform: 'scale(1.1)', opacity: '0.9' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .flower-shadow {
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }
    </style>
</head>
<body class="font-poppins overflow-hidden">
    <div id="loading-screen" class="fixed inset-0 z-50">
        <!-- Sky Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-b from-blue-300 via-blue-200 to-green-100"></div>
        
        <!-- Mountains (Background Layer) -->
        <div class="absolute bottom-0 left-0 right-0">
            <!-- Far Mountains -->
            <svg class="absolute bottom-0 w-full h-96" viewBox="0 0 1200 400" preserveAspectRatio="none">
                <path d="M0,400 L0,200 Q150,50 300,100 T600,80 T900,120 T1200,100 L1200,400 Z" 
                      fill="#1a643c" opacity="0.6" class="animate-mountain-mist"/>
                <path d="M0,400 L0,250 Q200,80 400,140 T800,110 T1200,150 L1200,400 Z" 
                      fill="#175032" opacity="0.8"/>
            </svg>
            
            <!-- Near Mountains -->
            <svg class="absolute bottom-0 w-full h-80" viewBox="0 0 1200 350" preserveAspectRatio="none">
                <path d="M0,350 L0,180 Q100,60 250,120 T500,90 T750,130 T1000,100 T1200,140 L1200,350 Z" 
                      fill="#14422a"/>
            </svg>
        </div>

        <!-- Flower Meadow Ground -->
        <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-green-700 to-green-500"></div>
        
        <!-- Flower Field -->
        <div class="absolute bottom-40 left-0 right-0 h-48">
            <!-- Large Flowers -->
            <div class="absolute bottom-0 left-1/4 animate-flower-sway flower-shadow" style="animation-delay: 0.5s;">
                <div class="relative animate-bloom" style="animation-delay: 0.5s;">
                    <div class="w-6 h-6 bg-flower-pink rounded-full mx-auto"></div>
                    <div class="w-1 h-8 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 right-1/3 animate-flower-sway flower-shadow" style="animation-delay: 1s;">
                <div class="relative animate-bloom" style="animation-delay: 1s;">
                    <div class="w-8 h-8 bg-flower-yellow rounded-full mx-auto"></div>
                    <div class="w-1 h-10 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 left-1/2 animate-flower-sway flower-shadow" style="animation-delay: 1.5s;">
                <div class="relative animate-bloom" style="animation-delay: 1.5s;">
                    <div class="w-7 h-7 bg-flower-purple rounded-full mx-auto"></div>
                    <div class="w-1 h-9 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <!-- Medium Flowers -->
            <div class="absolute bottom-0 left-1/6 animate-flower-sway flower-shadow" style="animation-delay: 0.3s;">
                <div class="relative animate-bloom" style="animation-delay: 0.3s;">
                    <div class="w-5 h-5 bg-flower-blue rounded-full mx-auto"></div>
                    <div class="w-1 h-6 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 right-1/4 animate-flower-sway flower-shadow" style="animation-delay: 0.8s;">
                <div class="relative animate-bloom" style="animation-delay: 0.8s;">
                    <div class="w-6 h-6 bg-flower-pink rounded-full mx-auto"></div>
                    <div class="w-1 h-7 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <!-- Small Flowers -->
            <div class="absolute bottom-0 left-1/5 animate-flower-sway flower-shadow" style="animation-delay: 0.2s;">
                <div class="relative animate-bloom" style="animation-delay: 0.2s;">
                    <div class="w-4 h-4 bg-flower-white rounded-full mx-auto"></div>
                    <div class="w-1 h-5 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 right-1/5 animate-flower-sway flower-shadow" style="animation-delay: 0.7s;">
                <div class="relative animate-bloom" style="animation-delay: 0.7s;">
                    <div class="w-4 h-4 bg-flower-yellow rounded-full mx-auto"></div>
                    <div class="w-1 h-5 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 left-3/4 animate-flower-sway flower-shadow" style="animation-delay: 1.2s;">
                <div class="relative animate-bloom" style="animation-delay: 1.2s;">
                    <div class="w-5 h-5 bg-flower-purple rounded-full mx-auto"></div>
                    <div class="w-1 h-6 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 right-3/4 animate-flower-sway flower-shadow" style="animation-delay: 1.7s;">
                <div class="relative animate-bloom" style="animation-delay: 1.7s;">
                    <div class="w-5 h-5 bg-flower-blue rounded-full mx-auto"></div>
                    <div class="w-1 h-6 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <!-- Tiny Flowers -->
            <div class="absolute bottom-0 left-1/10 animate-flower-sway flower-shadow" style="animation-delay: 0.1s;">
                <div class="relative animate-bloom" style="animation-delay: 0.1s;">
                    <div class="w-3 h-3 bg-flower-white rounded-full mx-auto"></div>
                    <div class="w-1 h-4 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 right-1/10 animate-flower-sway flower-shadow" style="animation-delay: 0.6s;">
                <div class="relative animate-bloom" style="animation-delay: 0.6s;">
                    <div class="w-3 h-3 bg-flower-pink rounded-full mx-auto"></div>
                    <div class="w-1 h-4 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 left-4/5 animate-flower-sway flower-shadow" style="animation-delay: 1.1s;">
                <div class="relative animate-bloom" style="animation-delay: 1.1s;">
                    <div class="w-3 h-3 bg-flower-yellow rounded-full mx-auto"></div>
                    <div class="w-1 h-4 bg-green-600 mx-auto"></div>
                </div>
            </div>
            
            <div class="absolute bottom-0 right-4/5 animate-flower-sway flower-shadow" style="animation-delay: 1.6s;">
                <div class="relative animate-bloom" style="animation-delay: 1.6s;">
                    <div class="w-3 h-3 bg-flower-purple rounded-full mx-auto"></div>
                    <div class="w-1 h-4 bg-green-600 mx-auto"></div>
                </div>
            </div>
        </div>

        <!-- Animated Birds -->
        <div class="absolute top-20 w-8 h-4 animate-birds">
            <svg class="w-8 h-4" viewBox="0 0 32 16" fill="none">
                <path d="M4 8 C4 6, 6 4, 8 6 C10 4, 12 6, 12 8 C12 6, 14 4, 16 6 C18 4, 20 6, 20 8" 
                      stroke="#374151" stroke-width="2" fill="none"/>
                <circle cx="6" cy="7" r="1" fill="#374151"/>
                <circle cx="18" cy="7" r="1" fill="#374151"/>
            </svg>
        </div>
        
        <div class="absolute top-32 w-6 h-3 animate-birds" style="animation-delay: 3s;">
            <svg class="w-6 h-3" viewBox="0 0 24 12" fill="none">
                <path d="M3 6 C3 5, 4 3, 6 4 C8 3, 9 5, 9 6 C9 5, 11 3, 12 4 C14 3, 15 5, 15 6" 
                      stroke="#4B5563" stroke-width="1.5" fill="none"/>
                <circle cx="4" cy="5.5" r="0.5" fill="#4B5563"/>
                <circle cx="13" cy="5.5" r="0.5" fill="#4B5563"/>
            </svg>
        </div>

        <div class="absolute top-16 w-10 h-5 animate-birds" style="animation-delay: 6s;">
            <svg class="w-10 h-5" viewBox="0 0 40 20" fill="none">
                <path d="M5 10 C5 8, 7 6, 10 8 C13 6, 15 8, 15 10 C15 8, 18 6, 20 8 C23 6, 25 8, 25 10" 
                      stroke="#374151" stroke-width="2" fill="none"/>
                <circle cx="8" cy="9" r="1" fill="#374151"/>
                <circle cx="22" cy="9" r="1" fill="#374151"/>
            </svg>
        </div>

        <!-- Floating Petals -->
        <div class="absolute top-1/3 left-1/4 animate-leaves">
            <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none">
                <path d="M8 2 C6 4, 4 6, 4 10 C4 12, 6 14, 8 14 C10 14, 12 12, 12 10 C12 6, 10 4, 8 2 Z" 
                      fill="#f472b6"/>
            </svg>
        </div>
        
        <div class="absolute top-1/2 right-1/3 animate-leaves" style="animation-delay: 3s;">
            <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none">
                <path d="M6 1 C5 2, 3 4, 3 7 C3 9, 4 11, 6 11 C8 11, 9 9, 9 7 C9 4, 7 2, 6 1 Z" 
                      fill="#facc15"/>
            </svg>
        </div>

        <div class="absolute top-2/3 left-2/3 animate-leaves" style="animation-delay: 5s;">
            <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none">
                <path d="M8 2 C6 4, 4 6, 4 10 C4 12, 6 14, 8 14 C10 14, 12 12, 12 10 C12 6, 10 4, 8 2 Z" 
                      fill="#a855f7"/>
            </svg>
        </div>

        <!-- Clouds -->
        <div class="absolute top-10 left-0 animate-journey opacity-70">
            <svg class="w-24 h-12" viewBox="0 0 96 48" fill="none">
                <ellipse cx="16" cy="32" rx="16" ry="12" fill="white"/>
                <ellipse cx="32" cy="24" rx="20" ry="16" fill="white"/>
                <ellipse cx="48" cy="28" rx="18" ry="14" fill="white"/>
                <ellipse cx="64" cy="32" rx="16" ry="12" fill="white"/>
                <ellipse cx="80" cy="30" rx="12" ry="10" fill="white"/>
            </svg>
        </div>
        
        <div class="absolute top-20 left-0 animate-journey opacity-60" style="animation-delay: 8s;">
            <svg class="w-20 h-10" viewBox="0 0 80 40" fill="none">
                <ellipse cx="12" cy="26" rx="12" ry="10" fill="white"/>
                <ellipse cx="28" cy="20" rx="16" ry="12" fill="white"/>
                <ellipse cx="44" cy="24" rx="14" ry="11" fill="white"/>
                <ellipse cx="60" cy="26" rx="12" ry="10" fill="white"/>
            </svg>
        </div>

        <div class="absolute top-6 left-0 animate-journey opacity-50" style="animation-delay: 15s;">
            <svg class="w-16 h-8" viewBox="0 0 64 32" fill="none">
                <ellipse cx="10" cy="20" rx="10" ry="8" fill="white"/>
                <ellipse cx="24" cy="16" rx="12" ry="10" fill="white"/>
                <ellipse cx="38" cy="18" rx="11" ry="9" fill="white"/>
                <ellipse cx="50" cy="20" rx="10" ry="8" fill="white"/>
            </svg>
        </div>

        <!-- Enhanced Sun with More Rays -->
        <div class="absolute top-16 right-20 animate-pulse-slow">
            <div class="w-16 h-16 bg-yellow-300 rounded-full shadow-lg relative z-10"></div>
            <div class="absolute inset-0 w-16 h-16 bg-yellow-200 rounded-full animate-ping opacity-20"></div>
            
            <!-- Enhanced Sun rays with more sticks -->
            <div class="absolute inset-0 w-16 h-16 animate-sun-rays">
                <!-- Main 4 directions -->
                <div class="absolute w-1 h-8 bg-yellow-300 rounded-full -top-10 left-1/2 transform -translate-x-1/2"></div>
                <div class="absolute w-1 h-8 bg-yellow-300 rounded-full -bottom-10 left-1/2 transform -translate-x-1/2"></div>
                <div class="absolute w-8 h-1 bg-yellow-300 rounded-full -left-10 top-1/2 transform -translate-y-1/2"></div>
                <div class="absolute w-8 h-1 bg-yellow-300 rounded-full -right-10 top-1/2 transform -translate-y-1/2"></div>
                
                <!-- Diagonal rays -->
                <div class="absolute w-1 h-6 bg-yellow-200 rounded-full -top-7 -left-4 transform rotate-45"></div>
                <div class="absolute w-1 h-6 bg-yellow-200 rounded-full -top-7 -right-4 transform -rotate-45"></div>
                <div class="absolute w-1 h-6 bg-yellow-200 rounded-full -bottom-7 -left-4 transform -rotate-45"></div>
                <div class="absolute w-1 h-6 bg-yellow-200 rounded-full -bottom-7 -right-4 transform rotate-45"></div>
                
                <!-- Additional medium rays -->
                <div class="absolute w-1 h-5 bg-yellow-400 rounded-full -top-8 left-1/4 transform rotate-12"></div>
                <div class="absolute w-1 h-5 bg-yellow-400 rounded-full -top-8 right-1/4 transform -rotate-12"></div>
                <div class="absolute w-1 h-5 bg-yellow-400 rounded-full -bottom-8 left-1/4 transform -rotate-12"></div>
                <div class="absolute w-1 h-5 bg-yellow-400 rounded-full -bottom-8 right-1/4 transform rotate-12"></div>
                
                <!-- Side medium rays -->
                <div class="absolute w-5 h-1 bg-yellow-400 rounded-full -left-8 top-1/4 transform rotate-12"></div>
                <div class="absolute w-5 h-1 bg-yellow-400 rounded-full -left-8 bottom-1/4 transform -rotate-12"></div>
                <div class="absolute w-5 h-1 bg-yellow-400 rounded-full -right-8 top-1/4 transform -rotate-12"></div>
                <div class="absolute w-5 h-1 bg-yellow-400 rounded-full -right-8 bottom-1/4 transform rotate-12"></div>
                
                <!-- Small additional rays -->
                <div class="absolute w-1 h-3 bg-yellow-500 rounded-full -top-6 left-1/3 transform rotate-30"></div>
                <div class="absolute w-1 h-3 bg-yellow-500 rounded-full -top-6 right-1/3 transform -rotate-30"></div>
                <div class="absolute w-1 h-3 bg-yellow-500 rounded-full -bottom-6 left-1/3 transform -rotate-30"></div>
                <div class="absolute w-1 h-3 bg-yellow-500 rounded-full -bottom-6 right-1/3 transform rotate-30"></div>
                
                <!-- Tiny decorative rays -->
                <div class="absolute w-3 h-1 bg-yellow-500 rounded-full -left-6 top-1/3 transform rotate-30"></div>
                <div class="absolute w-3 h-1 bg-yellow-500 rounded-full -left-6 bottom-1/3 transform -rotate-30"></div>
                <div class="absolute w-3 h-1 bg-yellow-500 rounded-full -right-6 top-1/3 transform -rotate-30"></div>
                <div class="absolute w-3 h-1 bg-yellow-500 rounded-full -right-6 bottom-1/3 transform rotate-30"></div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 flex items-center justify-center min-h-screen">
            <div class="text-center px-4">
                <!-- Logo/Icon -->
                <div class="mb-8 animate-bounce-slow">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 18-7-5-7 5 7-18z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-6xl font-bold text-primary-800 mb-4 animate-fade-in">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-500">
                        Agro Wisata
                    </span>
                </h1>
                <h2 class="text-2xl md:text-4xl font-semibold text-primary-700 mb-6 animate-slide-in">
                    Gunung Mas
                </h2>
                
                <!-- Subtitle -->
                <p class="text-lg md:text-xl text-primary-100 mb-8 animate-fade-in" style="animation-delay: 1s;">
                    Menjelajahi Keindahan Alam & Wisata Edukasi
                </p>

                <!-- Loading Animation -->
                <div class="flex items-center justify-center space-x-2 mb-8 animate-fade-in" style="animation-delay: 2s;">
                    <div class="w-3 h-3 bg-primary-500 rounded-full animate-bounce"></div>
                    <div class="w-3 h-3 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                    <div class="w-3 h-3 bg-primary-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                </div>

                <!-- Loading Text -->
                <p class="text-primary-100 font-medium animate-pulse" id="loading-text">
                    Sedang memuat....
                </p>
            </div>
        </div>

        <!-- Bottom Decorative Element -->
        <div class="absolute bottom-0 left-0 right-0 h-2 bg-gradient-to-r from-primary-500 via-secondary-400 to-primary-500"></div>
    </div>

    <!-- Main Website Content (Hidden Initially) -->
    <div id="main-content" class="hidden">
        <!-- Paste your existing website content here -->
        <div class="min-h-screen bg-gradient-to-br from-primary-50 to-secondary-50 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-primary-800 mb-4">Selamat Datang!</h1>
                <p class="text-lg text-primary-600">Website Agro Wisata Gunung Mas berhasil dimuat</p>
                <button onclick="window.location.href='/welcome2'" class="mt-4 bg-primary-600 text-white px-6 py-3 rounded-full hover:bg-primary-700 transition-colors">
                    Lihat Lebih Lanjut!
                </button>
            </div>
        </div>
    </div>

    <script>
        // Loading sequence
        const loadingTexts = [
            "Menyiapkan bunga-bunga...",
            "Menghias taman...",
            "Menyemai benih...",
            "Menyiapkan pengalaman terbaik...",
            "Hampir selesai..."
        ];

        let currentTextIndex = 0;
        const loadingTextElement = document.getElementById('loading-text');

        // Change loading text every 1.5 seconds
        const textInterval = setInterval(() => {
            if (currentTextIndex < loadingTexts.length - 1) {
                currentTextIndex++;
                loadingTextElement.textContent = loadingTexts[currentTextIndex];
            }
        }, 1500);

        // Hide loading screen and show main content after 8 seconds
        setTimeout(() => {
            clearInterval(textInterval);
            document.getElementById('loading-screen').style.opacity = '0';
            document.getElementById('loading-screen').style.transition = 'opacity 1s ease-out';
            
            setTimeout(() => {
                document.getElementById('loading-screen').classList.add('hidden');
                document.getElementById('main-content').classList.remove('hidden');
                document.getElementById('main-content').style.opacity = '0';
                document.getElementById('main-content').style.transition = 'opacity 1s ease-in';
                
                setTimeout(() => {
                    document.getElementById('main-content').style.opacity = '1';
                }, 100);
            }, 1000);
        }, 8000);

        // Add click to skip animation
        document.getElementById('loading-screen').addEventListener('click', () => {
            clearInterval(textInterval);
            document.getElementById('loading-screen').style.opacity = '0';
            document.getElementById('loading-screen').style.transition = 'opacity 0.5s ease-out';
            
            setTimeout(() => {
                document.getElementById('loading-screen').classList.add('hidden');
                document.getElementById('main-content').classList.remove('hidden');
                document.getElementById('main-content').style.opacity = '1';
            }, 500);
        });
    </script>
</body>
</html>