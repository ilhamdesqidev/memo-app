<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('username', function ($attribute, $value, $parameters, $validator) {
            // Contoh validasi: hanya huruf, angka, underscore dan titik
            return preg_match('/^[a-zA-Z0-9_.]+$/', $value);
        });
        
        // Pesan error custom (opsional)
        Validator::replacer('username', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Format :attribute tidak valid.');
        });
    }
    
protected $policies = [
    \App\Models\User::class => \App\Policies\UserPolicy::class,
];
}
