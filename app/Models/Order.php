<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'payment_reference',
        'amount',
        'status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'amount' => 'float',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
