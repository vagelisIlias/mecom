<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{   
    // Dashboard view
    public function adminDashboard()
    {
        return view('admin.index');

    }

    // Admin Login
    public function adminLogin()
    {   
        return view('admin.admin_login');
    }

    // Logout method
    public function adminLogout(Request $request): RedirectResponse 
    {
        // 1. Logout the user
        Auth::guard('web')->logout();

        // 2. Invalidate the session
        $request->session()->invalidate();

        // 3. Regenerate the CSRF token
        $request->session()->regenerateToken();

        // 4. Redirect to the admin login page
        return redirect('/admin/login');
    }

    // Admin Profile
    public function adminProfile() 
    {   
        // Get the authenticated user's ID
        $id = Auth::user()->id;
        // Find the user in the database using the retrieved ID
        $adminProfile = User::find($id);
        return view('admin.profile.admin_profile', compact('adminProfile'));
    }

    // Store Profile
    public function adminProfileStore(Request $request)
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
    
        // Check if a new profile photo was uploaded
        if ($request->file('photo')) {
            $file = $request->file('photo');

            // Unlink the images
            @unlink(public_path('upload/admin_profile_image/'. $data->photo));
            
            // Generate a unique filename for the uploaded photo
            $filename = date('Y-m-d H:i:s') . $file->getClientOriginalName();
            
            // Move the uploaded photo to the specified directory
            $file->move(public_path('upload/admin_profile_image'), $filename);
            
            // Update the 'photo' field in the user's data with the new filename
            $data->photo = $filename;
        }
    
        // Save the updated user data to the database
        $data->save();

        // Creating a message notification
        $notification = [
            'message' => 'Admin Porfile Updated Successfully',
            'alert-type' => 'success',
        ];
    
        // Redirect back to the previous page after saving
        return redirect()->back()->with($notification);
    }

   // Admin Change Password
    public function adminChangePassword()
    {
        // Fetch additional data from the database
        $id = auth()->user()->id;
        $adminChangePassword = User::findOrFail($id);

        return view('admin.profile.admin_change_password', compact('adminChangePassword'));
    }

    // Admin Update Password
    public function adminUpdatePassword(Request $request)
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
            'message' => 'Admin Password Updated Successfully',
            'alert-type' => 'success',
        ];
        
        return back()->with($not_succ);
    }

}
