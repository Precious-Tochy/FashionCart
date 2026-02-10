@component('mail::message')
# Thank you for your order, {{ $order->name }}

Your order **{{ $order->order_number }}** has been successfully placed.

**Shipping Address:**  
{{ $order->address }}, {{ $order->city }}, {{ $order->state }}

**Order Details:**

| Product | Image | Price | Quantity | Subtotal |
|---------|-------|-------|----------|----------|
@foreach($order->items as $item)
| {{ $item->product_name }} | <img src="{{ $item->product_image }}" width="50"> | ₦{{ number_format($item->price) }} | {{ $item->quantity }} | ₦{{ number_format($item->price * $item->quantity) }} |
@endforeach

**Total:** ₦{{ number_format($order->amount) }}

Payment Reference: **{{ $order->payment_reference }}**  

Thanks for shopping with us!  
@endcomponent
