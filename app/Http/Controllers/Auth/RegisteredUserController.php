<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Notifications\AccountStatusChanged;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {   
        // Validation users
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255',],
            'postcode' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => 'required',
        ]);

        // Create users
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Send a notification indicating that the user is registered successfully
        $url = url('/dashboard');
        $message = 'Thank you for your interest in our shop, your account has been successfully registered. 
                    Please follow the link to visit your main dashboard.';
        $actionText = "Visit Your Dashboard";
        $lineText = "Thank you for your interest in using our application";
        $user->notify(new AccountStatusChanged('register', $message, $url, $actionText, $lineText));

        // Notification Message
        $not_succ = [
            'message' => "Welcome {$user->username}, Your Account Created Successfully",
            'alert-type' => 'success',
        ];

        return redirect(RouteServiceProvider::HOME)->with($not_succ);
    }
}
