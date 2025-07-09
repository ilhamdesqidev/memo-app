<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
  // Di LoginRequest.php atau form request Anda
// app/Http/Requests/Auth/LoginRequest.php
public function rules()
{
    return [
        'username' => 'required|string', // Ganti dari 'username' ke 'string'
        'password' => 'required|string',
    ];
}

public function authenticate()
{
    // Ganti attempt dengan username
    if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
        ]);
    }


    RateLimiter::clear($this->throttleKey());
}

public function throttleKey(): string
{
    return Str::transliterate(Str::lower($this->string('username')).'|'.$this->ip());
}
}
