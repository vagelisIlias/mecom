<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exceptions\CustomException;
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
        $user->findOrFail(Auth::id())->update($request->updateUserData())->save();
        
        return redirect()->back()->with($notification->message('User Porfile Updated Successfully', 'success'));
    }

    // User Logout // ** REFACTORED
    public function destroy(NotificationService $notification): RedirectResponse 
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login')->with($notification->message('You have been logged out successfully', 'success'));
    }

    // User Logout // ** REFACTORED
    public function updatePassword(UpdatePasswordRequest $request, PasswordService $password, NotificationService $notification)
    {
        if (! $password->checkPassword($request->old_password, auth()->user()->id)) {
            return back()->withErrors([
                'old_password' => 'The old password is not much our records',
            ]);
        }

        if ($request->new_password !== $request->new_password_confirmation) {
            return back()->withErrors([
                'new_password' => 'The new password is not much with confirmation password',
                'new_password_confirmation' => 'The confirmation password is not much the new password',
            ]);
        }

        // Update New Password
        $password->updatePassword(auth()->user()->id, $request->new_password);
        return back()->with($notification->message('Your password updated successfully', 'success'));
    }
}