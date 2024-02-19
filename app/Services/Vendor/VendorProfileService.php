<?php

namespace App\Services\Vendor;

use App\Http\Requests\Vendor\VendorDataRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class VendorProfileService
{
    // Update vendors profile
    public function updateVendorProfile(User $user, VendorDataRequest $request)
    {
        // Passing the data via request
        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            $this->deleteVendorOldImage($user);
            $validatedData['photo'] = $this->uploadVendorPhoto($request->file('photo'));
        }

        $user->update($validatedData);
    }

    // Delete vendors old image
    private function deleteVendorOldImage(User $user)
    {
        if (! is_null($user->photo) && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }
    }

    // Upload vendors new image
    private function uploadVendorPhoto($file)
    {
        return $file->store('vendor_profile_image', 'public');
    }
}
