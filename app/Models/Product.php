<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Define the relationship to Multiimage model
    public function multiImages()
    {
        return $this->hasMany(MultiImage::class);
    }

    // Define the relationship to User model
    public function vendorShopName()
    {
        return $this->belongsTo(User::class, 'product_vendor_id', 'id');
    }

    // Define the relationship to User model
    public function productCategoryID()
    {
        return $this->belongsTo(Category::class, 'product_category_id', 'id');
    }
}
