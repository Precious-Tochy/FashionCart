<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dress;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    // -------------------------------
    // INITIALIZE PAYMENT
    // -------------------------------
    public function initialize(Request $request)
    {
        $validated = $request->validate([
    'email' => 'required|email',
    'amount' => 'required|numeric|min:1',
    'name' => 'required|string',
    'phone' => 'required|string',
    'address' => 'required|string',
    'city' => 'required|string',
    'state' => 'required|string',  // already your delivery state
    'delivery_fee' => 'required|numeric|min:0',
]);


        $reference = 'REF_' . time();

        session([
            'checkout_info' => $validated,
            'payment_reference' => $reference
        ]);

        return response()->json([
            'status' => true,
            'reference' => $reference
        ]);
    }

    // -------------------------------
    // VERIFY PAYMENT
    // -------------------------------
    
public function verify(Request $request)
{
    $reference = $request->reference;

    // 1️⃣ Verify payment with Paystack
    $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
        ->get("https://api.paystack.co/transaction/verify/{$reference}")
        ->json();

    if (!($response['status'] && isset($response['data']['status']) && $response['data']['status'] === 'success')) {
        return response()->json([
            'status' => false,
            'message' => 'Payment verification failed'
        ]);
    }

    // 2️⃣ Check if order already exists
    if ($existing = Order::where('payment_reference', $reference)->first()) {
        $this->clearCart();
        session()->forget('checkout_info');

        return response()->json([
            'status' => true,
            'redirect' => route('order.success', $existing->id)
        ]);
    }

    // 3️⃣ Get checkout info from session
    $checkout = session('checkout_info');
    if (!$checkout) {
        return response()->json([
            'status' => false,
            'message' => 'Checkout session expired.'
        ]);
    }

    // 4️⃣ Get cart items
    $cart = $this->getCart();
    if ($cart->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Cart is empty.'
        ]);
    }

    // 5️⃣ Use DB transaction to ensure atomicity
    DB::beginTransaction();
    try {
        // Create order
        
            $order = Order::create([
    'order_number' => 'ORD-' . strtoupper(Str::random(6)),
    'user_id' => Auth::id(),
    'name' => $checkout['name'],
    'phone' => $checkout['phone'],
    'email' => $checkout['email'],
    'address' => $checkout['address'],
    'city' => $checkout['city'],
    'state' => $checkout['state'],
    'delivery_fee' => $checkout['delivery_fee'],  // <-- store fee
    'amount' => ($response['data']['amount'] / 100) + $checkout['delivery_fee'], // include delivery
    'payment_reference' => $reference,
    'status' => 'paid'
]);

        

        // Save order items and reduce stock safely
        foreach ($cart as $item) {
            $dress = Dress::find($item->product_id);
            if (!$dress) continue; // skip if product missing

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'product_image' => $item->product_image,
                'color' => $item->color,
                'size' => $item->size
            ]);

            // Reduce stock safely
            $variants = json_decode($dress->variants, true);
            if (isset($variants[$item->color][$item->size])) {
                $variants[$item->color][$item->size] -= $item->quantity;
                $variants[$item->color][$item->size] = max(0, $variants[$item->color][$item->size]);
                $dress->variants = json_encode($variants);
                $dress->save();
            }
        }

        // Clear cart and session
        $this->clearCart();
        session()->forget('checkout_info');

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Order creation failed: ".$e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Failed to process order. Please contact support.'
        ]);
    }

    // 6️⃣ Send email (log failures)
    try {
        Mail::to($order->email)->send(new OrderPlacedMail($order));
    } catch (\Exception $e) {
        Log::error("Order email failed for order {$order->id}: ".$e->getMessage());
    }

    // 7️⃣ Return success with redirect
    return response()->json([
        'status' => true,
        'redirect' => route('order.success', $order->id)
    ]);
}


    // -------------------------------
    // HELPERS
    // -------------------------------
    private function getCart()
    {
        return Cart::where('session_id', session()->getId())
            ->orWhere('user_id', Auth::id())
            ->get();
    }

    private function clearCart()
    {
        Cart::where('session_id', session()->getId())
            ->orWhere('user_id', Auth::id())
            ->delete();
    }

    public function paymentSuccess($order_id)
    {
        $order = Order::with('items')->findOrFail($order_id);
        return view('order-success', compact('order'));
    }
}
