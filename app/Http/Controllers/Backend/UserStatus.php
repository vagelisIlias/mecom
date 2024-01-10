<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserStatus extends Controller
{
    public function allUserStatus()
    {
        $allUserStatus = User::where('role', 'user')
            ->get();

        return view('admin.backend.user.user_status', compact('allUserStatus'));
    }
}
