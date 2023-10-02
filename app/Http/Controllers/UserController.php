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
        // Get the authenticated user's ID
        $id = Auth::user()->id;

        // Find the user in the database using the retrieved ID
        $userData = User::find($id);

        return view('index', compact('userData'));
    }

    // Store user data in database
    public function userProfileStore(Request $request)
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
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->postcode = $request->postcode;

        // Check if a new profile photo was uploaded
        if ($request->file('photo')) {
            $file = $request->file('photo');

            // Unlink the images
            @unlink(public_path('upload/user_profile_image/'. $data->photo));
            
            // Generate a unique filename for the uploaded photo
            $filename = date('Y-m-d H:i:s') . $file->getClientOriginalName();
            
            // Move the uploaded photo to the specified directory
            $file->move(public_path('upload/user_profile_image'), $filename);
            
            // Update the 'photo' field in the user's data with the new filename
            $data->photo = $filename;
        }
        
        // Save the updated user data to the database
        $data->save();

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
