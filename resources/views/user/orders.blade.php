@extends('layouts.user layout')

@section('content')
<h1>My Orders</h1>

@if($orders->isEmpty())
    <p style="margin-top: 1.2rem">You haven't placed any orders yet.</p>
@else
    <table class="orders-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d M, Y') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>&#8358;{{ number_format($order->amount, 2) }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
<style>
.orders-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
@media(max-width:768px){
   .orders-table{
    margin-left:-1rem; 
   } 
}
.orders-table th, .orders-table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: center;
}

.orders-table th {
    background-color: #ae5a8d;
    color: #fff;
}

.orders-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.orders-table a {
    color: #ae5a8d;
    text-decoration: none;
}

.orders-table a:hover {
    text-decoration: underline;
}
</style>
@endsection
