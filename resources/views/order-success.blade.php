@extends('layouts.index layout')

@section('content')
<div style="max-width:700px; margin:70px auto; padding:30px; text-align:center;">
    <div style="
        background:#fff;
        padding:40px;
        border-radius:20px;
        border:1px solid #eee;
        box-shadow:0 4px 20px rgba(0,0,0,0.06);
    ">
        {{-- Success Icon --}}
        <div>
            <svg width="90" height="90" fill="none" stroke="#ac7094" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M8 12l2 2l4 -4"></path>
            </svg>
        </div>

        <h1 style="margin-top:20px; color:#ac7094; font-size:30px; font-weight:700;">
            Payment Successful!
        </h1>

        <p style="font-size:17px; color:#555; margin-top:10px;">
            Thank you <strong>{{ $order->name }}</strong>, your order has been received.
        </p>

        <hr style="margin:25px 0;">

        {{-- Order Summary --}}
        <h3 style="color:#333; font-weight:600;">Order Summary</h3>
        <div style="text-align:left; margin-top:20px; font-size:16px; line-height:1.8;">
            <p><strong>Order Number:</strong> <span style="color:#ac7094;">{{ $order->order_number }}</span></p>
            <p><strong>Full Name:</strong> {{ $order->name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Delivery Address:</strong> {{ $order->address }}</p>
            <p><strong>State:</strong> {{ $order->state }}</p>
            <p><strong>Payment Reference:</strong> <span style="color:#ac7094;">{{ $order->payment_reference }}</span></p>
            <p><strong>Total Paid:</strong> ₦{{ number_format($order->amount) }}</p>

            <h3>Order Items:</h3>
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f5f5f5;">
                        <th style="padding:10px; border:1px solid #ddd;">Product</th>
                        <th style="padding:10px; border:1px solid #ddd;">Image</th>
                        <th style="padding:10px; border:1px solid #ddd;">Price</th>
                        <th style="padding:10px; border:1px solid #ddd;">Quantity</th>
                        <th style="padding:10px; border:1px solid #ddd;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $item->product_name }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">
                           <img src="{{ asset('project/image/' . $item->product_image) }}" width="50" alt="{{ $item->product_name }}">

                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">₦{{ number_format($item->price) }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $item->quantity }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">₦{{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="margin-top:15px; font-weight:600; font-size:16px;">Total: ₦{{ number_format($order->amount) }}</p>
        </div>

        <hr style="margin:25px 0;">

        <a href="{{url('/')}}" 
           style="
                display:inline-block; 
                background:#ac7094;
                color:white;
                padding:12px 25px;
                border-radius:8px;
                text-decoration:none;
                font-size:16px;
                margin-top:20px;
           ">
            Continue Shopping
        </a>
    </div>
</div>
@endsection
