<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Services\Password\PasswordService;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Services\Notification\NotificationService;

class UserController extends Controller
{
    // Creating the dashboard for user  // ** REFACTORED
    public function index(User $user)
    {   
        $request = $user->findOrFail(Auth::id());
        return view('index', ['user' => $request]);
    }

    // Store user data in database // ** REFACTORED
    public function updateProfile(CreateUserRequest $request, User $user, NotificationService $notification)
    {   
        // Find the user
        $update = $user->findOrFail(Auth::id());

        // Update user data
        tap($update)->update($request->updateUserData())->save();
        
        return redirect()->back()->with($notification->message('User Porfile Updated Successfully', 'success'));
    }

    // User Logout // ** REFACTORED
    public function destroy(): RedirectResponse 
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        session()->flash('success', 'You have been logged out successfully.');

        return redirect('/login');
    }

    // User update password // ** REFACTORED
    public function updatePassword(UpdatePasswordRequest $request, PasswordService $password, NotificationService $notification)
    {
        if (! $password->checkPassword($request->old_password, auth()->user()->id)) {
            return redirect()->back()->with($notification->message('Old password does not match', 'error'));
        }

        // Update New Password
        $password->updatePassword(auth()->user()->id, $request->new_password);
        return redirect()->back()->with($notification->message('User password updated successfully', 'success'));
    }
}