<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\User\CreateUserRequest;

class UserController extends Controller
{
    // Creating the dashboard for user  // ** REFACTORED
    public function dashboard(User $user)
    {   
        $request = $user->findOrFail(Auth::id());
        return view('index', ['user' => $request]);
    }

    // Store user data in database // ** REFACTORED
    public function update(CreateUserRequest $request, User $user)
    {   
        // Find the user
        $update = $user->findOrFail(Auth::id());

        // Update user data
        tap($update)->update($request->updateUserData())->save();

        // Creating a message notification
        $notification = [
            'message' => 'User Porfile Updated Successfully',
            'alert-type' => 'success',
        ];
    
        // Redirect back to the previous page after saving
        return redirect()->back()->with($notification);
    }

    // User Logout
    public function userLogout(Request $request): RedirectResponse 
    {
        // Logout the user
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the user login page
        return redirect('/login');
    }

    // User update password
    public function userUpdatePassword(Request $request)
    {
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        // Check Matching Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            // Display an error message using Toastr
            $not_error = [
                'message' => 'Old Password Does Not Match, Please re-type your current password',
                'alert-type' => 'error',
            ];
            // Redirect to the dashboard
            return redirect()->route('dashboard')->with($not_error);
        }

        // Update New Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Pass the additional data to the view along with the success message
        $not_succ = [
            'message' => 'User Password Updated Successfully',
            'alert-type' => 'success',
        ];
        
        // Redirect to the dashboard
        return redirect()->route('dashboard')->with($not_succ);
    }
}
