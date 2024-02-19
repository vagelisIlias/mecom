<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\Vendor\VendorDataRequest;
use App\Http\Requests\Vendor\VendorRegisterRequest;
use App\Models\User;
use App\Notifications\AccountStatusChanged;
use App\Services\Notification\NotificationService;
use App\Services\Password\PasswordService;
use App\Services\Vendor\VendorProfileService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /**
     * Dashboard view ** REFACTORED **
     */
    public function index()
    {
        return view('vendor.index');
    }

    /**
     * Vendor login ** REFACTORED **
     */
    public function vendorLogin()
    {
        return view('vendor.vendor_login');
    }

    /**
     * Vendor logout ** REFACTORED **
     */
    public function logout(NotificationService $notification): RedirectResponse
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/vendor/login')->with($notification->message('You have been logged out successfully', 'success'));
    }

    /**
     * Vendor profile ** REFACTORED **
     */
    public function vendorProfile(User $user)
    {
        return view('vendor.profile.vendor_profile', ['user' => $user]);
    }

    /**
     * Vendor profile update ** REFACTORED **
     */
    public function update(NotificationService $notification, VendorProfileService $profileService, VendorDataRequest $request, User $user)
    {
        $profileService->updateVendorProfile($user, $request);

        return redirect()->back()->with($notification->message('Vendor Profile Updated Successfully', 'success'));
    }

    /**
     * Vendor change password ** REFACTORED **
     */
    public function vendorChangePassword(User $user)
    {
        return view('vendor.profile.vendor_change_password', ['user' => $user]);
    }

    /**
     * Vendor update password ** REFACTORED **
     */
    public function vendorUpdatePassword(UpdatePasswordRequest $request, PasswordService $password, NotificationService $notification)
    {
        if (! $password->checkPassword($request->old_password, auth()->user()->id)) {
            return back()->withErrors([
                'old_password' => 'The old password is not much in our records',
            ]);
        }

        $password->updatePassword(auth()->user()->id, $request->new_password);

        return back()->with($notification->message('Your password updated successfully', 'success'));
    }

    /**
     * New vendor ** REFACTORED **
     */
    public function create()
    {
        return view('auth.become_vendor');
    }

    /**
     * Vendor register ** REFACTORED **
     */
    public function vendorRegister(VendorRegisterRequest $request, NotificationService $notification, User $user)
    {
        $newVendorUser = $user->create($request->createVendorData());

        event(new Registered($newVendorUser));

        $url = url('/');
        $message = 'Thank you for your interest in becoming a vendor. 
                    Your account has been successfully registered. 
                    Please allow some time for your account to be activated and you will be notified via email. 
                    In the meantime, please feel free to check our shop.';
        $actionText = 'Visit Our Shop';
        $lineText = 'Thank you for your interest in using our application';
        $newVendorUser->notify(new AccountStatusChanged('register', $message, $url, $actionText, $lineText));

        return redirect()->route('vendor.login')
            ->with($notification
                ->message("Welcome {$newVendorUser->username}, Your Account Created Successfully. Please wait for your Account to be Activated", 'success'));
    }
}
