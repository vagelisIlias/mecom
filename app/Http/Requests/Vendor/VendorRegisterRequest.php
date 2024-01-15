<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Http\FormRequest;

class VendorRegisterRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'vendor_shop_name' => 'required|string|max:255|unique:users',
            'address' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'vendor_join' => 'required',
            'password' => 'required', 'confirmed', Password::defaults(),
            'password_confirmation' => 'required',
            'role' => 'vendor',
            'status' => 'inactive',
        ];
    }
}
