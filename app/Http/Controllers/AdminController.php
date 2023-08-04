<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class AdminController extends Controller
{   
    // Return dashboard view
    public function adminDashboard()
    {
        return view('admin.index');

    } // End method adminDashboard


    // Admin Login
    public function adminLogin(Request $request)
    {   
        return view('admin.admin_login');
    } // End method adminLogin

    // Logout method
    public function adminLogout(Request $request): RedirectResponse 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } // End method adminLogout

  

}
