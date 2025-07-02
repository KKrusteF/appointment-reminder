<?php

namespace App\Http\Actions;

use App\Models\User;

class ProfileAction
{
    public function execute(array $attributes): User
    {
        $profile = auth()->user();

        $profile->update($attributes);

        return $profile;
    }
}
