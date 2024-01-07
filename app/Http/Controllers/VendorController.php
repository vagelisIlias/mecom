<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Notifications\AccountStatusChanged;
use App\Services\Notification\NotificationService;

class VendorController extends Controller
{
    // Dashboard view ** REFACTORED **
    public function index() 
    {
        return view('vendor.index');
    }

    // Vendor Login
    public function vendorLogin()
    {   
        // The middleware has already checked the status
        return view('vendor.vendor_login');
    }

    // Vendor logout ** REFACTORED **
    public function logout(NotificationService $notification): RedirectResponse 
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/vendor/login')->with($notification->message('You have been logged out successfully', 'success'));
    }

    // Vendor Profile  ** REFACTORED **
    public function vendorProfile(User $user)
    {   
        return view('vendor.profile.vendor_profile', ['user' => $user]);
    }

    // Vedor Profile Store
    public function store(Request $request)
    {
        // Get the authenticated user's ID
        $id = Auth::user()->id;

        // Find the user in the database using the retrieved ID
        $data = User::find($id);

        // Update user's profile information with data from the request
        $data->firstname = $request->firstname;
        $data->lastname = $request->lastname;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->github = $request->github;
        $data->instagram = $request->instagram;
        $data->linkedin = $request->linkedin;
        $data->job_title = $request->job_title;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->postcode = $request->postcode;
        $data->vendor_shop_name = $request->vendor_shop_name;
        $data->vendor_join = $request->vendor_join;
        $data->vendor_short_info = $request->vendor_short_info;

        // Check if a new profile photo was uploaded
        if ($request->file('photo')) {
            $file = $request->file('photo');

            // Unlink the images
            @unlink(public_path('upload/vendor_profile_image/'. $data->photo));
            
            // Generate a unique filename for the uploaded photo
            $filename = date('Y-m-d H:i:s') . $file->getClientOriginalName();
            
            // Move the uploaded photo to the specified directory
            $file->move(public_path('upload/vendor_profile_image'), $filename);
            
            // Update the 'photo' field in the user's data with the new filename
            $data->photo = $filename;
        }

        // Save the updated user data to the database
        $data->save();

        // Creating a message notification
        $notification = [
            'message' => 'Vendor Porfile Updated Successfully',
            'alert-type' => 'success',
        ];
    
        // Redirect back to the previous page after saving
        return redirect()->back()->with($notification);
    }

    // Change Password
    public function vendorChangePassword()
    {
        // Fetch additional data from the database
        $id = auth()->user()->id;
        $vendorChangePassword = User::findOrFail($id);

        return view('vendor.profile.vendor_change_password', compact('vendorChangePassword'));
    }

    // Update Password
    public function vendorUpdatePassword(Request $request)
    {
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // Check Matching Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            // Display an error message using Toastr
            $not_error = [
                'message' => 'Old Password Does Not Match',
                'alert-type' => 'error',
            ];
            return back()->with($not_error);
        }

        // Update New Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Pass the additional data to the view along with the success message
        $not_succ = [
            'message' => 'Vendor Password Updated Successfully',
            'alert-type' => 'success',
        ];
        
        return back()->with($not_succ);
    }

    // Become a Vendor 
    public function becomeVendor()
    {
        return view('auth.become_vendor');
    }

    // Register Vendor
    public function vendorRegister(Request $request)
    {   
        // Validation vendor users
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'vendor_shop_name' => ['required', 'string', 'max:255', 'unique:users'],
            'address' => ['required'],
            'postcode' => ['required'],
            'phone' => ['required',],
            'vendor_join' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => 'required',
        ]);

        // Create vendor users
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'vendor_shop_name' => $request->vendor_shop_name,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'phone' => $request->phone,
            'vendor_join' => $request->vendor_join,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',
        ]);

        event(new Registered($user));

        // Send a notification indicating that the vendor user is registered successfully
        $url = url('/');
        $message = 'Thank you for your interest in becoming a vendor. 
                    Your account has been successfully registered. 
                    Please allow some time for your account to be activated and you will be notified via a new email. 
                    In the meantime, please feel free to check our shop.';
        $actionText = "Visit Our Shop";
        $lineText = "Thank you for your interest in using our application";
        $user->notify(new AccountStatusChanged('register', $message, $url, $actionText, $lineText));

        // Notification Message
        $not_succ = [
            'message' => "Welcome {$user->username}, Your Account Created Successfully. Please wait for your Account to be Activated.",
            'alert-type' => 'success',
        ];

        return redirect()->route('vendor.login')->with($not_succ);
    }
}
