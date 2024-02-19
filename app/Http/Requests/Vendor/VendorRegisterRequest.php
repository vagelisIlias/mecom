<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'password' => 'required', 'confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function createVendorData(): array
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'email' => $this->email,
            'vendor_shop_name' => $this->vendor_shop_name,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'slug' => Str::slug($this->vendor_shop_name),
            'role' => 'vendor',
            'status' => 'inactive',
        ];
    }
}
