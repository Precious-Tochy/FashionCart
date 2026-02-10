<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Dress;
use App\Models\Delivery;


class CartController extends Controller
{
    // -------------------------------
    // ADD TO CART
    // -------------------------------
    public function addToCart(Request $request)
    {
        $request->validate([
            'dress_id' => 'required|integer|exists:dresses,id',
            'color' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $dress = Dress::findOrFail($request->dress_id);

        $color = strtolower($request->color);
        $size = strtolower($request->size);
        $qty = $request->quantity;

        $variants = json_decode($dress->variants, true);
        if (!is_array($variants)) {
            return response()->json(['status' => false, 'message' => 'Product variants are not available.']);
        }

        // Convert variant keys to lowercase
        $variantsLower = [];
        foreach ($variants as $c => $sizes) {
            $cLower = strtolower($c);
            $variantsLower[$cLower] = [];
            foreach ($sizes as $s => $stock) {
                $variantsLower[$cLower][strtolower($s)] = $stock;
            }
        }

        if (!isset($variantsLower[$color][$size])) {
            return response()->json(['status' => false, 'message' => 'Selected variant does not exist']);
        }

        $userId = Auth::id();
        $sessionId = session()->getId();

        // Check existing quantity in cart for this variant
        $existingQty = Cart::where('product_id', $dress->id)
            ->where('color', $color)
            ->where('size', $size)
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('session_id', $sessionId);
                if ($userId) $q->orWhere('user_id', $userId);
            })->sum('quantity');

        $availableStock = $variantsLower[$color][$size] - $existingQty;

        if ($availableStock <= 0) {
            return response()->json(['status' => false, 'message' => 'This item is out of stock.']);
        }

        if ($qty > $availableStock) {
            return response()->json(['status' => false, 'message' => "Only {$availableStock} item(s) available for this variant."]);
        }

        $cartItem = Cart::where('product_id', $dress->id)
            ->where('color', $color)
            ->where('size', $size)
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('session_id', $sessionId);
                if ($userId) $q->orWhere('user_id', $userId);
            })->first();

        if ($cartItem) {
            $cartItem->quantity += $qty;
            $cartItem->save();
        } else {
            Cart::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'product_id' => $dress->id,
                'product_name' => $dress->name,
                'product_image' => $dress->image1,
                'size' => $size,
                'color' => $color,
                'price' => $dress->price,
                'quantity' => $qty,
            ]);
        }

        $cartCount = Cart::where('session_id', $sessionId)
            ->orWhere('user_id', $userId)
            ->sum('quantity');

        return response()->json([
            'status' => true,
            'message' => "Item added to cart successfully!",
            'cart_count' => $cartCount
        ]);
    }

    // -------------------------------
    // DISPLAY CART
    // -------------------------------
    public function index()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $cart = Cart::where('session_id', $sessionId)
            ->orWhere('user_id', $userId)
            ->get();

        return view('bag', compact('cart'));
    }

    // -------------------------------
    // UPDATE QUANTITY
    // -------------------------------
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::find($request->cart_id);
        if (!$cart) {
            return response()->json(['status' => false, 'message' => 'Cart item not found.']);
        }

        $dress = Dress::find($cart->product_id);
        if (!$dress) {
            return response()->json(['status' => false, 'message' => 'Product not found.']);
        }

        $variants = json_decode($dress->variants, true);
        if (!is_array($variants)) {
            return response()->json(['status' => false, 'message' => 'Product variants are not available.']);
        }

        // Convert keys to lowercase
        $variantsLower = [];
        foreach ($variants as $c => $sizes) {
            $cLower = strtolower($c);
            $variantsLower[$cLower] = [];
            foreach ($sizes as $s => $stock) {
                $variantsLower[$cLower][strtolower($s)] = $stock;
            }
        }

        $userId = Auth::id();
        $sessionId = session()->getId();
        $color = strtolower($cart->color);
        $size = strtolower($cart->size);

        // Total quantity of this variant in cart excluding current item
        $otherQty = Cart::where('product_id', $cart->product_id)
            ->where('color', $cart->color)
            ->where('size', $cart->size)
            ->where(function ($q) use ($userId, $sessionId) {
                $q->where('session_id', $sessionId)->orWhere('user_id', $userId);
            })
            ->sum('quantity') - $cart->quantity;

        $availableStock = ($variantsLower[$color][$size] ?? 0) - $otherQty;

        if ($availableStock <= 0) {
            return response()->json(['status' => false, 'message' => 'This item is out of stock.']);
        }

        if ($request->quantity > $availableStock) {
            return response()->json([
                'status' => false,
                'message' => "Only $availableStock item(s) available for this product."
            ]);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        $itemTotal = $cart->price * $cart->quantity;
        $subtotal = Cart::where(function ($q) use ($userId, $sessionId) {
            $q->where('user_id', $userId)->orWhere('session_id', $sessionId);
        })->get()->sum(fn($item) => $item->price * $item->quantity);

        $cartCount = Cart::where(function ($q) use ($userId, $sessionId) {
            $q->where('user_id', $userId)->orWhere('session_id', $sessionId);
        })->sum('quantity');

        return response()->json([
            'status' => true,
            'message' => 'Quantity updated successfully.',
            'itemTotal' => $itemTotal,
            'subtotal' => $subtotal,
            'cartCount' => $cartCount
        ]);
    }

    // -------------------------------
    // REMOVE ITEM
    // -------------------------------
    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id'
        ]);

        $cart = Cart::find($request->cart_id);
        if (!$cart) {
            return response()->json(['status' => false, 'message' => 'Cart item not found.']);
        }

        $cart->delete();

        $subtotal = Cart::where('user_id', Auth::id() ?? null)
            ->get()
            ->sum(fn($item) => $item->price * $item->quantity);

        return response()->json([
            'status' => true,
            'message' => 'Item removed successfully.',
            'subtotal' => $subtotal
        ]);
    }

    // -------------------------------
    // CHECKOUT
    // -------------------------------
     // make sure this is imported

public function checkout()
{
    $cart = Cart::where('user_id', auth()->id() ?? null)->get();
    
    if ($cart->isEmpty()) {
    return redirect('/')
           ->with('message', 'Your cart is empty.');
}


    $subtotal = $cart->sum(fn($item) => $item->price * $item->quantity);

    // ✅ Load delivery fees
    $deliveries = Delivery::all();

    return view('checkout', compact('cart', 'subtotal', 'deliveries'));
}


    // -------------------------------
    // CART COUNT
    // -------------------------------
    public function cartCount()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $count = Cart::where('session_id', $sessionId)
            ->orWhere('user_id', $userId)
            ->sum('quantity');

        return response()->json(['count' => $count]);
    }

    // -------------------------------
    // PAYMENT SUCCESS
    // -------------------------------
    public function paymentSuccess($order_id)
    {
        $order = Order::with('items')->findOrFail($order_id);
        return view('order-success', compact('order'));
    }
}
