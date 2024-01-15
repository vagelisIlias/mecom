<?php

namespace App\Policies;

use App\Models\User;

class VendorPolicy
{
    /**
     * Determine if the user is an active vendor.
     */
    public function authorize(User $user)
    {
        return $user->status === 'active';
    }
}
