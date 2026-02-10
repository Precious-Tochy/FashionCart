@extends('layouts.user layout')

@section('content')

<style>
/* Container */
.order-container {
    max-width: 900px;
    margin: 20px auto;
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    font-family: 'Poppins', sans-serif;
}

/* Header */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
    margin-bottom: 25px;
}

.order-header h1 {
    font-size: 28px;
    color: #ac5b8c; /* Your brand accent color */
    font-weight: 700;
}

.order-header p {
    font-size: 14px;
    color: #555;
}

/* Status Badge */
.order-status {
    padding: 6px 14px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    text-transform: capitalize;
    color: #fff;
}

.order-status.pending { background: #ff9900; }
.order-status.completed { background: #28a745; }
.order-status.cancelled { background: #dc3545; }

/* Order Items Table */
.order-items {
    margin-top: 30px;
}

.order-items table {
    width: 100%;
    border-collapse: collapse;
}

.order-items th,
.order-items td {
    text-align: left;
    padding: 12px 15px;
}

.order-items th {
    background: #fdf0f7;
    color: #ac5b8c;
    font-weight: 600;
    font-size: 15px;
}

.order-items td {
    border-bottom: 1px solid #eee;
    font-size: 14px;
    color: #444;
}

/* Total Section */
.total-section {
    margin-top: 25px;
    text-align: right;
    font-size: 20px;
    font-weight: 700;
    color: #ac5b8c;
}

/* Back Button */
.back-btn {
    display: inline-block;
    margin-top: 30px;
    padding: 12px 20px;
    background: #ac5b8c;
    color: #fff !important;
    text-decoration: none;
    font-size: 14px;
    border-radius: 8px;
    transition: background 0.3s;
}

.back-btn:hover {
    background: #8b4571;
}

/* Responsive */
@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        gap: 10px;
    }

    .order-items th, .order-items td {
        font-size: 13px;
        padding: 10px;
    }

    .total-section {
        font-size: 18px;
    }
}
</style>

<div class="order-container">

    <!-- Order Header -->
    <div class="order-header">
        <div style="display: flex; flex-direction:column; gap:4px;">
        <h4>Order #{{ $order->id }}</h4>
        <h1>{{ $order->order_number ?? $order->id }}</h1></div>

        <div>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>
            <br>
            <p><strong>Status:</strong> 
                @php
    // Default to 'pending' if status is null
    $status = $order->status ?? 'pending';

    // Map statuses to CSS classes
    $statusClass = match(strtolower($status)) {
        'pending' => 'pending',
        'completed', 'paid' => 'completed',
        'cancelled', 'failed' => 'cancelled',
        default => 'pending',
    };
@endphp

<span class="order-status {{ $statusClass }}">
    {{ ucfirst($status) }}
</span>

            </p>
        </div>
    </div>

    <!-- Order Items -->
    <div class="order-items">
        <h3>Items in Your Order</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price (₦)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="total-section">
        Total: ₦{{ number_format($order->amount, 2) }}
    </div>

    <!-- Back Button -->
    <a href="{{ route('orders') }}" class="back-btn">Back to My Orders</a>

</div>

@endsection
