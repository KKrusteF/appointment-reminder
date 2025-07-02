<?php

namespace App\Http\Actions\Auth;

use App\Models\User;

class RegisterAction
{
    public function execute(array $attributes): User
    {
        return User::create($attributes);
    }
}
