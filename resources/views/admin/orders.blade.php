@extends('layouts.admin layout')

 @include('sweetalert::alert')
@section('content')
<div class="container" style="margin-top:50px;">
    <h1 style="margin-bottom:20px; color:#ac708e;">Orders</h1>

    {{-- Tabs for filtering --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.orders') }}" 
           style="margin-right:10px; {{ request()->is('admin/orders') ? 'font-weight:bold;' : '' }}">All</a>

        <a href="{{ route('admin.orders.pending') }}" 
           style="margin-right:10px; {{ request()->is('admin/orders/pending') ? 'font-weight:bold;' : '' }}">Pending</a>

        <a href="{{ route('admin.orders.paid') }}" 
           style="{{ request()->is('admin/orders/paid') ? 'font-weight:bold;' : '' }}">Paid</a>
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.orders') }}" style="margin-bottom:20px;">
        <input type="text" name="search" placeholder="Search by order number, name, email, phone" 
               value="{{ request('search') }}" style="padding:8px; width:300px;">
        <button type="submit" style="padding:8px 12px; background:#ac708e; color:#fff; border:none; border-radius:4px;">
            Search
        </button>
    </form>

    @if($orders->count())
    <div class="orders-table-wrapper">
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:10px; border:1px solid #ddd;">Order #</th>
                    <th style="padding:10px; border:1px solid #ddd;">Customer</th>
                    <th style="padding:10px; border:1px solid #ddd;">Email</th>
                    <th style="padding:10px; border:1px solid #ddd;">Phone</th>
                    <th style="padding:10px; border:1px solid #ddd;">Total</th>
                    <th style="padding:10px; border:1px solid #ddd;">Status</th>
                    <th style="padding:10px; border:1px solid #ddd;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $order->order_number }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $order->name ?? $order->user->name ?? 'Guest' }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $order->email ?? $order->user->email ?? 'N/A' }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $order->phone ?? 'N/A' }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">₦{{ number_format($order->amount) }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                            @csrf
                            <select name="status" onchange="this.form.submit()" style="padding:5px; border-radius:4px;">
                                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                <option value="paid" {{ $order->status=='paid'?'selected':'' }}>Paid</option>
                                <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td style="padding:10px; border:1px solid #ddd;">
                        <a href="{{ route('admin.orders.view', $order->id) }}" 
                           style="padding:5px 10px; background:#ac708e; color:#fff; border-radius:4px;">View</a>
                        <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="padding:5px 10px; background:#e74c3c; color:#fff; border:none; border-radius:4px;"
                                    onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div style="margin-top:20px;">
            {{ $orders->links() }}
        </div>
    @else
        <p>No orders found.</p>
    @endif
</div>
<style>
    /* ===============================
   ORDERS TABLE RESPONSIVE
   (Laptop untouched)
================================ */

/* Default: Laptop & Desktop */
.orders-table-wrapper {
    overflow: visible;
    
}

/* iPad & Phone ONLY */
@media (max-width: 1024px) {
    .orders-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .orders-table-wrapper table {
        min-width: 900px;
    }
}

/* Phones */
@media (max-width: 768px) {
    .orders-table-wrapper table {
        min-width: 900px;
        
    }
}

</style>
@endsection
