<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'divisi' => \App\Http\Middleware\CekDivisi::class, // ini benar
        ]);
    })
    

        // Jika ada middleware tambahan bisa tambahkan di sini
        // $middleware->web(append: [...]);
    ->withExceptions(function (Exceptions $exceptions) {
        // Tambahkan konfigurasi exception handler jika perlu
    })
    ->create();