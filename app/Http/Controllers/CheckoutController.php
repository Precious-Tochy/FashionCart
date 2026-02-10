<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Delivery;


class CheckoutController extends Controller
{
    public function index()
{
    $cart = Cart::where('user_id', auth()->id())->get();
    $subtotal = $cart->sum(function($item) { 
        return $item->price * $item->quantity; 
    });

    // Get all delivery options
    $deliveries = Delivery::all();

    return view('checkout', compact('cart', 'subtotal', 'deliveries'));
}

public function checkout()
{
    $cart = session('cart', []);

    $subtotal = collect($cart)->sum(function($item){
        return $item['price'] * $item['quantity'];
    });

    // Get all delivery options
    $deliveries = Delivery::all();

    return view('checkout', compact('cart', 'subtotal', 'deliveries'));
}

}
