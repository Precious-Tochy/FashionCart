@extends('layouts.admin layout')

@section('content')
<div class="container" style="margin-top:50px;">
    <h1 style="margin-bottom:20px; color:#ac708e;">Order #{{ $order->order_number }}</h1>

    <h3>Customer Details</h3>
    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
    <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->state }}</p>

    <h3>Order Items</h3>
    <table style="width:100%; border-collapse: collapse; margin-top:10px;">
        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:10px; border:1px solid #ddd;">Item</th>
                <th style="padding:10px; border:1px solid #ddd;">Quantity</th>
                <th style="padding:10px; border:1px solid #ddd;">Price</th>
                <th style="padding:10px; border:1px solid #ddd;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td style="padding:10px; border:1px solid #ddd;">{{ $item->product_name }}</td>
                <td style="padding:10px; border:1px solid #ddd;">{{ $item->quantity }}</td>
                <td style="padding:10px; border:1px solid #ddd;">₦{{ number_format($item->price) }}</td>
                <td style="padding:10px; border:1px solid #ddd;">₦{{ number_format($item->price * $item->quantity) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin-top:20px;">Subtotal: ₦{{ number_format($order->subtotal) }}</h3>
    <h3>Total: ₦{{ number_format($order->total) }}</h3>

    <a href="{{ route('admin.orders') }}" style="padding:8px 12px; background:#ac708e; color:#fff; border-radius:4px;">Back to Orders</a>
</div>
@endsection
