<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\AccountStatusChanged;
use App\Services\VendorStatusDetails;

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

    // Admin Logout
    public function adminLogout(Request $request): RedirectResponse 
    {
        // Logout the user
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the admin login page
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

        // Pass the success message
        $not_succ = [
            'message' => 'Admin Password Updated Successfully',
            'alert-type' => 'success',
        ];
        
        return redirect()->back()->with($not_succ);
    }

    // ----------------------- Vendor Status Details -------------------------------- //

    protected $vendorStatusDetails;
    
    public function __construct(VendorStatusDetails $vendorStatusDetails)
    {
        $this->vendorStatusDetails = $vendorStatusDetails;
    }

    // Returning the vendor status details based on Eloquent request
    public function allVendorStatus()
    {   
        // Get active vendors using $this->vendorStatusDetails
        $getActiveVendors = $this->vendorStatusDetails->getActiveVendors();

        // Get inactive vendors using $this->vendorStatusDetails
        $getInactiveVendors = $this->vendorStatusDetails->getInactiveVendors();

        // Combine active and inactive vendors into a single collection
        $allVendorStatus = $getActiveVendors->concat($getInactiveVendors);

        // Load the view with the combined collection
        return view('backend.vendor.vendor_status', compact('allVendorStatus'));
    }

    // Vendor Status Details
    public function checkVendorDetails($id)
    {   
        // Return the id of the vendor status
        $checkVendorDetails = User::findOrFail($id);
        return view('backend.vendor.change_vendor_status', compact('checkVendorDetails'));
    }

    // Change Vendor Status
    public function changeVendorStatus(Request $request)
    {   
        $vendor_id = $request->id;
        $vendor = User::findOrFail($vendor_id);

        if ($vendor->status === 'inactive') {
            // Update the status to 'active'
            $vendor->update(['status' => 'active']);

            // Send a notification indicating that the account is now active
            $url = url('/vendor/login');
            $message = 'Your account has been activated. Please follow the link below to visit your main dahsboard.';
            $actionText = "Visit Your Dashboard";
            $lineText = "Thank you for using our application";
            $vendor->notify(new AccountStatusChanged('active', $message, $url, $actionText, $lineText));
            
            // Pass the success message
            $not_succ = [
                'message' => 'Vendor has been Activated Successfully',
                'alert-type' => 'success',
            ];
            
        } else {

            // Update the status to 'inactive'
            $vendor->update(['status' => 'inactive']);
    
            // Send a notification indicating that the account is now inactive
            $url = url('/');
            $message = "Your account has been deactivated. 
                        You don't have access to your dashboard. 
                        Please contact the support team for further information regarding your account.";
            $actionText = "Visit Our Shop";
            $lineText = "Thank you for using our application";
            $vendor->notify(new AccountStatusChanged('inactive', $message, $url, $actionText, $lineText));

            // Pass the success message
            $not_succ = [
                'message' => 'Vendor has been Deactivated uccessfully',
                'alert-type' => 'success',
            ];
                
        }

        return redirect()->route('all.vendor.status')->with($not_succ);       
    }

    // Delete Vendor Details
    public function deleteVendorDetails($id)
    {   
        $vendor = User::findOrFail($id);
        try {
            // Check the details based on ID
            $deleteVendorDetails = User::findOrFail($id);

            // Delete vendor details
            $deleteVendorDetails->delete();

            // Send a notification indicating that the account is now deleted
            $url = url('/');
            $message = 'Unfortunately, your account has been deleted. 
                        If you have any questions or need assistance, please contact our support team.
                        Please feel free to visit our website in the following link.';
            $actionText = "Visit Our Shop";
            $lineText = "Thank you for using our application";
            $vendor->notify(new AccountStatusChanged('delete', $message, $url, $actionText, $lineText));

            // Success message notification
            $not_succ = [
                'message' => 'Vendor Deleted Successfully',
                'alert-type' => 'success',
            ];
        } catch(\Exception $e) {
            // Error message notification
            $not_error = [
                'message' => 'Error deleting vendor details' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($not_error);
        }
        return redirect()->route('all.vendor.status')->with($not_succ);
    }

    // -------------------------- User Status Details -------------------------------- //

    public function allUserStatus()
    {
        $allUserStatus = User::where('role','user')
                                ->get();
        return view('backend.user.user_status', compact('allUserStatus'));
    }
}
