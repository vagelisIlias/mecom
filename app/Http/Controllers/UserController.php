<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Services\Password\PasswordService;
use App\Http\Requests\User\UserDataRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Services\Notification\NotificationService;

class UserController extends Controller
{
    /**
     * Return Index ** REFACTORED **
     */
    public function index(User $user)
    {   
        $request = $user->findOrFail(Auth::id());
        return view('index', ['user' => $request]);
    }
    /**
     * Update Update Profile // ** REFACTORED
     */
    public function updateProfile(UserDataRequest $request, User $user, NotificationService $notification)
    {   
        // Find the user
        $user->findOrFail(Auth::id())->update($request->updateUserData());
        
        return redirect()->back()->with($notification->message('User Porfile Updated Successfully', 'success'));
    }
    /**
     * User Logout // ** REFACTORED
     */
    public function logout(NotificationService $notification): RedirectResponse 
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('login')->with($notification->message('You have been logged out successfully', 'success'));
    }
    /**
     * User Update Password // ** REFACTORED
     */
    public function updatePassword(UpdatePasswordRequest $request, PasswordService $password, NotificationService $notification)
    {
        if (! $password->checkPassword($request->old_password, auth()->user()->id)) {
            return back()->withErrors([
                'old_password' => 'The old password is not much in our records',
            ]);
        }

        // Update New Password
        $password->updatePassword(auth()->user()->id, $request->new_password);
        return back()->with($notification->message('Your password updated successfully', 'success'));
    }
}