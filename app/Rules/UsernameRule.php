<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UsernameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
{
    // Contoh: hanya boleh huruf, angka, dan underscore
    return preg_match('/^[a-zA-Z0-9_]+$/', $value);
}

public function message()
{
    return 'Username hanya boleh mengandung huruf, angka, dan underscore';
}

use App\Rules\UsernameRule;

public function rules()
{
    return [
        'username' => ['required', 'string', new UsernameRule],
        'password' => ['required', 'string'],
    ];
}
}
