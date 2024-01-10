<?php

namespace App\Services\Password;

use App\Exceptions\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public function checkPassword($old_password)
    {
        if (! Auth::check() || ! Hash::check($old_password, Auth::user()->password)) {
            // throw new CustomException("Old password does not match");
            return false;
        }

        return $this;
    }

    public function updatePassword($user, $newPassword)
    {
        if ($user) {
            User::whereId($user)->update([
                'password' => Hash::make($newPassword),
            ]);
        }
        // throw new CustomException("Password update failed");

        return $this;
    }
}
