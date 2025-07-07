<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .btn-primary {
                background: linear-gradient(135deg, #16a34a 0%, #ca8a04 100%);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #15803d 0%, #a16207 100%);
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
            }
            .input-focus:focus {
                border-color: #16a34a;
                box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="py-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>