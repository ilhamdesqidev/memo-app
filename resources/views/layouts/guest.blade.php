<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-hidden">
        <div class="h-screen bg-gradient-to-br from-green-50 to-yellow-50">
            <!-- Split layout container -->
            <div class="flex h-screen">
                <!-- Left side - Brand/Info -->
                <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-12 relative overflow-hidden">
                    <!-- Background Image -->
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80');">
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-green-900/80 via-green-800/70 to-yellow-900/60"></div>
                    </div>
                    
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-3xl"></div>
                        <div class="absolute bottom-20 right-20 w-24 h-24 bg-yellow-300 rounded-full blur-2xl"></div>
                        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white rounded-full blur-xl"></div>
                    </div>
                    
                    <div class="max-w-md text-center relative z-10">
                        <div class="w-24 h-24 mx-auto mb-8 bg-gradient-to-r from-yellow-400 to-green-400 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3">
                            <span class="text-white text-2xl font-bold">{{ substr(config('app.name', 'App'), 0, 1) }}</span>
                        </div>
                        <h1 class="text-4xl font-bold text-white mb-6 leading-tight">Welcome Back</h1>
                        <p class="text-green-100 text-lg leading-relaxed mb-8">Sign in to your account to continue accessing your dashboard and manage your data with ease.</p>
                        
                        <!-- Feature highlights -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-center space-x-3 text-green-100">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                <span class="text-sm">Secure & Encrypted</span>
                            </div>
                            <div class="flex items-center justify-center space-x-3 text-green-100">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                <span class="text-sm">Fast & Reliable</span>
                            </div>
                            <div class="flex items-center justify-center space-x-3 text-green-100">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                <span class="text-sm">24/7 Support</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side - Login Form -->
                <div class="flex-1 flex items-center justify-center p-6 lg:p-12">
                    <div class="w-full max-w-md">
                        <!-- Login Card -->
                        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 p-8 lg:p-10 relative overflow-hidden">
                            <!-- Card Background Pattern -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-200/30 to-yellow-200/30 rounded-full blur-3xl -translate-y-16 translate-x-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-yellow-200/20 to-green-200/20 rounded-full blur-2xl translate-y-12 -translate-x-12"></div>
                            
                            <!-- First Peeping Character (Bottom Left) -->
                            <div class="absolute -bottom-8 -left-6 z-0">
                                <div class="peeping-character-left">
                                    <!-- Head -->
                                    <div class="w-14 h-14 bg-gradient-to-b from-pink-200 to-pink-300 rounded-full relative shadow-lg">
                                        <!-- Hair -->
                                        <div class="absolute -top-2 left-1 w-12 h-8 bg-gradient-to-b from-purple-600 to-purple-700 rounded-full"></div>
                                        <!-- Eyes -->
                                        <div class="absolute top-4 left-2 w-2 h-2 bg-gray-800 rounded-full animate-blink-left"></div>
                                        <div class="absolute top-4 right-2 w-2 h-2 bg-gray-800 rounded-full animate-blink-left"></div>
                                        <!-- Nose -->
                                        <div class="absolute top-6 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-pink-400 rounded-full"></div>
                                        <!-- Mouth -->
                                        <div class="absolute top-8 left-1/2 transform -translate-x-1/2 w-2 h-1 bg-red-400 rounded-full"></div>
                                    </div>
                                    <!-- Body (partially hidden) -->
                                    <div class="w-10 h-6 bg-gradient-to-b from-green-400 to-green-500 rounded-t-lg -mt-2 mx-2 shadow-md"></div>
                                    <!-- Hands -->
                                    <div class="absolute top-10 -left-1 w-2 h-2 bg-pink-200 rounded-full shadow-sm"></div>
                                    <div class="absolute top-10 -right-1 w-2 h-2 bg-pink-200 rounded-full shadow-sm"></div>
                                </div>
                            </div>
                            
                            <!-- Second Peeping Character (Bottom Right) -->
                            <div class="absolute -bottom-8 -right-6 z-0">
                                <div class="peeping-character-right">
                                    <!-- Head -->
                                    <div class="w-16 h-16 bg-gradient-to-b from-orange-200 to-orange-300 rounded-full relative shadow-lg">
                                        <!-- Hair -->
                                        <div class="absolute -top-2 left-2 w-12 h-8 bg-gradient-to-b from-amber-600 to-amber-700 rounded-full"></div>
                                        <!-- Eyes -->
                                        <div class="absolute top-5 left-3 w-2 h-2 bg-gray-800 rounded-full animate-blink"></div>
                                        <div class="absolute top-5 right-3 w-2 h-2 bg-gray-800 rounded-full animate-blink"></div>
                                        <!-- Nose -->
                                        <div class="absolute top-7 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-orange-400 rounded-full"></div>
                                        <!-- Mouth -->
                                        <div class="absolute top-9 left-1/2 transform -translate-x-1/2 w-3 h-1 bg-pink-400 rounded-full"></div>
                                    </div>
                                    <!-- Body (partially hidden) -->
                                    <div class="w-12 h-8 bg-gradient-to-b from-blue-400 to-blue-500 rounded-t-lg -mt-2 mx-2 shadow-md"></div>
                                    <!-- Hands -->
                                    <div class="absolute top-12 -left-2 w-3 h-3 bg-orange-200 rounded-full shadow-sm"></div>
                                    <div class="absolute top-12 -right-2 w-3 h-3 bg-orange-200 rounded-full shadow-sm"></div>
                                </div>
                            </div>
                            
                            <!-- CSS Animation Styles -->
                            <style>
                                @keyframes peep-left {
                                    0% { transform: translateY(15px) translateX(-8px); opacity: 0; }
                                    15% { transform: translateY(0) translateX(0); opacity: 1; }
                                    80% { transform: translateY(0) translateX(0); opacity: 1; }
                                    100% { transform: translateY(15px) translateX(-8px); opacity: 0; }
                                }
                                
                                @keyframes peep-right {
                                    0% { transform: translateY(15px) translateX(8px); opacity: 0; }
                                    15% { transform: translateY(0) translateX(0); opacity: 1; }
                                    80% { transform: translateY(0) translateX(0); opacity: 1; }
                                    100% { transform: translateY(15px) translateX(8px); opacity: 0; }
                                }
                                
                                @keyframes blink {
                                    0%, 90%, 100% { transform: scaleY(1); }
                                    95% { transform: scaleY(0.1); }
                                }
                                
                                @keyframes blink-left {
                                    0%, 85%, 100% { transform: scaleY(1); }
                                    90% { transform: scaleY(0.1); }
                                }
                                
                                @keyframes peek-left-right {
                                    0%, 100% { transform: translateX(0); }
                                    25% { transform: translateX(-3px); }
                                    75% { transform: translateX(3px); }
                                }
                                
                                @keyframes peek-right-left {
                                    0%, 100% { transform: translateX(0); }
                                    25% { transform: translateX(3px); }
                                    75% { transform: translateX(-3px); }
                                }
                                
                                .peeping-character-left {
                                    animation: peep-left 6s ease-in-out infinite, peek-right-left 3s ease-in-out infinite;
                                    animation-delay: 0s, 1s;
                                }
                                
                                .peeping-character-right {
                                    animation: peep-right 5s ease-in-out infinite, peek-left-right 2.5s ease-in-out infinite;
                                    animation-delay: 2s, 3s;
                                }
                                
                                .animate-blink {
                                    animation: blink 3s ease-in-out infinite;
                                }
                                
                                .animate-blink-left {
                                    animation: blink-left 4s ease-in-out infinite;
                                }
                                
                                .peeping-character-left:hover {
                                    animation-duration: 1s;
                                }
                                
                                .peeping-character-right:hover {
                                    animation-duration: 1s;
                                }
                            </style>
                            
                            <div class="relative z-10 space-y-6">
                                <!-- Mobile logo -->
                                <div class="lg:hidden text-center">
                                    <div class="w-20 h-20 mx-auto bg-gradient-to-r from-green-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-6 shadow-xl transform hover:scale-105 transition-transform">
                                        <span class="text-white text-xl font-bold">{{ substr(config('app.name', 'App'), 0, 1) }}</span>
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Sign in to your account</h2>
                                    <p class="text-gray-600">Welcome back! Please enter your details</p>
                                </div>

                                <!-- Desktop header -->
                                <div class="hidden lg:block text-center">
                                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Sign in</h2>
                                    <p class="text-gray-600">Welcome back! Please enter your details</p>
                                </div>

                                <!-- Form Slot -->
                                {{ $slot }}

                                <!-- Footer Links -->
                                <div class="text-center border-t border-gray-200/50 pt-6">
                                    @if (Route::has('register'))
                                        <p class="text-sm text-gray-600">
                                            Don't have an account? 
                                            <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                                                Create account
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>