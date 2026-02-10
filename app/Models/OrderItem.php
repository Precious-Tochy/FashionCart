<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
    'order_id',
    'product_id',
    'product_name',
    'quantity',
    'price',
    'product_image',
    'color',
    'size',
    'meta'
];


    protected $casts = [
        'meta' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
