<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorDataRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'github' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
            'vendor_shop_name' => 'nullable|string|max:255',
            'vendor_short_info' => 'nullable|string|max:255',
        ];
    }

    public function updateVendorData()
    {
        return $this->only([
            'firstname',
            'lastname',
            'username',
            'email',
            'phone',
            'address',
            'postcode',
            'github',              
            'instagram',
            'linkedin',
            'job_title',
            'vendor_shop_name',
            'vendor_short_info'
        ]);
    }
}
