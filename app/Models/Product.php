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
}
