<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // Creating the dashboard for user
    public function userDashboard()
    {   
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('index', compact('userData'));
    }
}
