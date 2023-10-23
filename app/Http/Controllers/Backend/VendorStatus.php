<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Notifications\AccountStatusChanged;
use App\Services\VendorStatusDetails;

class VendorStatus extends Controller
{
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
        return view('admin.backend.vendor.vendor_status', compact('allVendorStatus'));
    }

    // Vendor Status Details
    public function checkVendorDetails($id)
    {   
        // Return the id of the vendor status
        $checkVendorDetails = User::findOrFail($id);
        return view('admin.backend.vendor.change_vendor_status', compact('checkVendorDetails'));
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
}
