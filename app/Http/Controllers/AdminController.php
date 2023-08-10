<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class AdminController extends Controller
{   
    // Return dashboard view
    public function adminDashboard()
    {
        return view('admin.index');

    } // End method adminDashboard


    // Admin Login
    public function adminLogin()
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

    // Admin Profile
    public function adminProfile() 
    {   
        $id = Auth::user()->id;
        $adminProfile = User::find($id);
        return view('admin.profile.admin_profile', compact('adminProfile'));
    } // End method adminProfile

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
            
            // Generate a unique filename for the uploaded photo
            $filename = date('Y-m-d H:i:s') . $file->getClientOriginalName();
            
            // Move the uploaded photo to the specified directory
            $file->move(public_path('upload/admin_profile_image'), $filename);
            
            // Update the 'photo' field in the user's data with the new filename
            $data->photo = $filename;
        }
    
        // Save the updated user data to the database
        $data->save();
    
        // Redirect back to the previous page after saving
        return redirect()->back();
    }
    

}
