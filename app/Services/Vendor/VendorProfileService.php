<?php

namespace App\Services\Vendor;

use App\Models\User;
use App\Http\Requests\Vendor\VendorDataRequest;
use Illuminate\Support\Facades\Storage;

class VendorProfileService
{
    public function updateProfile(User $user, VendorDataRequest $request)
    {   
        // Passing the data via request
        $validatedData = $request->validated();

        // Checking if user uploaded new image
        if ($request->hasFile('photo')) {
            $this->deleteOldImage($user);
            $validatedData['photo'] = $this->uploadPhoto($request->file('photo'));
        }
        // Update the profile
        $user->update($validatedData);
    }

    // Delete the old image
    private function deleteOldImage(User $user)
    {
        if (Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }
    }

    // Upload new image
    private function uploadPhoto($file)
    {
        return $file->store('vendor_profile_image', 'public');
    }
}
