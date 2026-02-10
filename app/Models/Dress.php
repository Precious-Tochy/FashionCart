<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class Dress extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'category_id',
        'variants',
        'price',
        'material',
        'description',
        'image1',
        'image2',
    ];

    protected $casts = [
        'variants' => 'array', // converts JSON to array automatically
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Check stock considering items in cart
    public function isOutOfStockConsideringCart()
    {
        $variants = $this->ensureVariantsArray($this->variants);

        if (empty($variants)) {
            return true; // no variants = out of stock
        }

        $cartItems = Cart::where('product_id', $this->id)
            ->where(function($q){
                $q->where('user_id', Auth::id())
                  ->orWhere('session_id', session()->getId());
            })->get();

        foreach ($variants as $color => $sizes) {
            if (!is_array($sizes)) continue;
            foreach ($sizes as $size => $stock) {
                $stock = intval($stock);
                $inCart = $cartItems->where('color', $color)
                                    ->where('size', $size)
                                    ->sum('quantity');
                if($stock - $inCart > 0) return false;
            }
        }
        return true;
    }

    // Check if out of stock ignoring cart
    public function isOutOfStock()
    {
        $variants = $this->ensureVariantsArray($this->variants);

        if (empty($variants)) return true;

        foreach ($variants as $color => $sizes) {
            if (!is_array($sizes)) continue;
            foreach ($sizes as $size => $stock) {
                if (intval($stock) > 0) return false;
            }
        }

        return true;
    }

    // Ensure $variants is always an array
    private function ensureVariantsArray($variants)
    {
        if (is_string($variants)) {
            $decoded = json_decode($variants, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($variants) ? $variants : [];
    }
}
