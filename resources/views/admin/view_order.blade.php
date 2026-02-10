@extends('layouts.admin layout')

@section('content')
<div class="container" style="margin-top:50px;" id="gr">
    <h1 style="margin-bottom:20px; color:#ac708e;">Order #{{ $order->order_number }}</h1>

    {{-- Customer Info --}}
    <div style="margin-bottom:20px;">
        <p><strong>Customer:</strong> {{ $order->name ?? $order->user->name ?? 'Guest' }}</p>
        <p><strong>Email:</strong> {{ $order->email ?? $order->user->email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
        <p><strong>Shipping Address:</strong> {{ $order->address ?? 'N/A' }}</p>
        <p><strong>State:</strong> {{ $order->state ?? 'N/A' }}</p>
        <p>
            <strong>Status:</strong>
            <span style="padding:4px 8px; border-radius:4px; background-color:
                @if($order->status == 'pending') #f1c40f
                @elseif($order->status == 'paid') #2ecc71
                @elseif($order->status == 'shipped') #3498db
                @elseif($order->status == 'completed') #8e44ad
                @elseif($order->status == 'cancelled') #e74c3c
                @endif;
                color:#fff;">
                {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>

    {{-- Update Status --}}
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="margin-bottom:20px;">
        @csrf
        <label for="status"><strong>Update Status:</strong></label>
        <select name="status" id="status" onchange="this.form.submit()" style="padding:5px; border-radius:4px;">
            <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
            <option value="paid" {{ $order->status=='paid'?'selected':'' }}>Paid</option>
            <option value="shipped" {{ $order->status=='shipped'?'selected':'' }}>Shipped</option>
            <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
            <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
        </select>
    </form>

    {{-- Order Items --}}
    <h3>Order Items</h3>
    <table style="width:100%; border-collapse: collapse;">
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
                    <img src="{{ asset('uploads/dress_pic/'.$item->product_image) }}" width="50" alt="{{ $item->product_name }}">
                </td>
                <td style="padding:10px; border:1px solid #ddd;">₦{{ number_format($item->price, 2) }}</td>
                <td style="padding:10px; border:1px solid #ddd;">{{ $item->quantity }}</td>
                <td style="padding:10px; border:1px solid #ddd;">₦{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="margin-top:20px;">Total: ₦{{ number_format($order->amount,2) }}</h4>

    <a href="{{ route('admin.orders') }}" style="padding:6px 12px; background:#ac708e; color:#fff; border-radius:4px; text-decoration:none;">Back to Orders</a>
</div>
<style>
    @media(max-width:768px){
        #gr{
           
           overflow: hidden;
            
        }
    }
</style>
@endsection
