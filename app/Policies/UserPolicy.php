<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function edit(User $authUser, User $user)
    {
        return $authUser->id === $user->id; // Allow editing only if the user is editing their own profile
    }
}