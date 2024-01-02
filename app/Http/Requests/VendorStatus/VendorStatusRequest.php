<?php

namespace App\Http\Requests\VendorStatus;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class VendorStatusRequest extends FormRequest
{
    public function getActiveVendors()
    {   
       return  User::where('status', 'active')
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
