<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\VendorStatus\VendorStatusRequest;;
use App\Notifications\AccountStatusChanged;

class VendorStatus extends Controller
{   
    // Check the Vendor Status
    public function allVendorStatus(VendorStatusRequest $request)
    {
        $activeVendors = $request->getActiveVendors();
        $inactiveVendors = $request->getInactiveVendors();
        $allVendorStatus = $activeVendors->concat($inactiveVendors);
    
        return view('admin.backend.vendor.vendor_status_all', compact('allVendorStatus'));
    }
    
    // Change Vendor Status
    public function changeVendorStatus($id)
    {   
        // $vendor_id = $request->id;
        $vendor = User::findOrFail($id);

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
                'message' => 'Vendor has been Deactivated Successfully',
                'alert-type' => 'success',
            ];    
        }
        return redirect()->route('all.vendor.status')->with($not_succ);       
    }

    // Edit Vendor Details
    public function editVendorDetails($id)
    {   
        $editVendorDetails = User::findOrFail($id);
        return view('admin.backend.vendor.vendor_edit', compact('editVendorDetails'));
    }

    // Update Vendor Profile
    public function updateVendorProfile(Request $request)
    {
        try {
            $id = $request->id;
            $vendor = User::findOrFail($id);

            // Validate the request data
            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'vendor_shop_name' => 'required|string|max:255',
            ]);

            // Update the specific fields
            $vendor->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'vendor_shop_name' => $request->vendor_shop_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'postcode' => $request->postcode,
            ]);
            
            // Pass the success message
            $not_succ = [
                'message' => 'Vendor Details Updated Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.vendor.status')->with($not_succ);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            $error = [
                'message' => 'Error updating vendor details: ' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($error);
        }
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

    // Add New Vendor
    public function addVendor()
    {
        return view('admin.backend.vendor.vendor_add');
    }

    // Store New Vendor
    public function storeVendorProfile(Request $request)
    {
       try{
            // Validate vendor profile
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                'vendor_shop_name' => 'required',
            ],[
                'username.unique' => 'The Username has already been taken. Please try a different Username',
                'email.unique' => 'The Email has already been taken. Please try a different Email',
            ]);

            // Create new vendor
            User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'vendor_shop_name' => ucfirst($request->vendor_shop_name),
                'phone' => $request->phone,
                'address' => $request->address,
                'postcode' => $request->postcode,
                'vendor_join' => $request->vendor_join,
                'role' => 'vendor',
                'status' => 'active',
            ]);

            // Success message notification
            $not_succ = [
                'message' => 'Vendor Account Created Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.vendor.status')->with($not_succ);
       } catch(\Exception $e) {
        // Error message notification
        $not_error = [
            'message' => '' . $e->getMessage(),
            'alert-type' => 'error',
        ];
        return redirect()->back()->with($not_error);
        }
    }
}
