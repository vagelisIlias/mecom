<?php

namespace App\Services;

use App\Models\User;

class VendorStatusDetails
{
    public function getActiveVendors()
    {
        return User::where('status', 'active')
            ->where('role', 'vendor')
            ->latest()
            ->get();
    }

    public function getInactiveVendors()
    {
        return User::where('status', 'inactive')
            ->where('role', 'vendor')
            ->latest()
            ->get();
    }

    
}
