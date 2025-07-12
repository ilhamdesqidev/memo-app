<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckDivisi;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\CheckRole::class,
        'divisi' => \App\Http\Middleware\CheckDivisi::class,
        'divisi' => \App\Http\Middleware\CekDivisi::class,
    ]);
})
        
        // You can add other middleware groups or modifications here if needed
        // $middleware->web(append: [
        //     \App\Http\Middleware\SomeMiddleware::class,
        // ]);

    ->withExceptions(function (Exceptions $exceptions) {
        // Configure exception handling here if needed
    })
    ->create();