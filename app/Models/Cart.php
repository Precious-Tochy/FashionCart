<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
   protected $fillable = [
    'session_id', 'user_id', 'product_id', 'product_name', 'product_image',
    'size', 'color', 'price', 'quantity'
];

}
