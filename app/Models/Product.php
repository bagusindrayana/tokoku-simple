<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillabel = [
        'product_name',
        'product_description',
        'product_price',
        'product_image',
        'product_slug',
        'product_detail_images',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
