<?php

namespace App\Http\Actions\Auth;

use Illuminate\Support\Facades\Hash;

class PasswordAction
{
    public function execute(array $attributes): void
    {
        $profile = auth()->user();

        $attributes['password'] = Hash::make($attributes['password']);
        $profile->update($attributes);
    }
}
