<?php

namespace App\Services\Password;

use App\Models\User;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public function checkPassword($old_password)
    {   
        if (! Auth::check() || ! Hash::check($old_password, Auth::user()->password)) {
            throw new CustomException("Password check failed"); 
        }
        
        return $this;
    }

    public function updatePassword($user, $newPassword)
    {
        try {
            User::whereId($user)->update([
                'password' => Hash::make($newPassword)
            ]);
        } catch (\Exception $e) {
            throw new CustomException("Password update failed");
        }

        return $this;
    }
}

