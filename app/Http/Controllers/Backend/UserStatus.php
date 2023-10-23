<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Notifications\AccountStatusChanged;
use App\Services\VendorStatusDetails;

class UserStatus extends Controller
{
   
    public function allUserStatus()
    {
        $allUserStatus = User::where('role','user')
                                ->get();
        return view('admin.backend.user.user_status', compact('allUserStatus'));
    }
}
