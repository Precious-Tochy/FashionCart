@extends('layouts.user layout')

@section('content')

<style>
/* ===== Dashboard Styles ===== */

.dashboard-container {
    max-width: 1100px;
    
    padding: 15px;
    font-family: "Poppins", sans-serif;
}

/* Banner */
.dashboard-banner {
    background: linear-gradient(135deg, #ac5b8c, #d88db4);
    padding: 35px;
    border-radius: 20px;
    color: #fff;
    box-shadow: 0 8px 30px rgba(172, 91, 140, 0.4);
    animation: fadeIn 0.6s ease;
}

.dashboard-banner h2 {
    font-size: 28px;
    font-weight: 700;
}

.dashboard-banner p {
    opacity: 0.9;
}

/* Stats Grid */
.dashboard-stats {
    margin-top: 30px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
}

.stat-card {
    background: #fff;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.07);
    text-align: center;
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}

.stat-icon {
    font-size: 35px;
    color: #ac5b8c;
    margin-bottom: 12px;
}

.stat-card h4 {
    font-size: 18px;
    font-weight: 600;
    color: #444;
}

.stat-card p {
    font-size: 22px;
    font-weight: 700;
    margin-top: 5px;
    color: #ac5b8c;
}

/* Recent Orders */
.recent-orders-box {
    background: #fff;
    margin-top: 40px;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.07);
}

.recent-orders-box h3 {
    color: #ac5b8c;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}
@media(max-width:768px){
   .recent-orders-box{
    overflow: hidden;
    padding: 7px;
    margin-left: -1.5rem;
    margin-right: -1.5rem;
   } 
   
}

.orders-table th {
    padding: 12px;
    text-align: left;
    background: #fce8f3;
    color: #ac5b8c;
}

.orders-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    color: #444;
}

.orders-table tr:hover {
    background: #faf5f8;
}

/* Status Colors */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    color: #fff;
    text-transform: capitalize;
}

.status-pending   { background: #ff9800; }
.status-paid      { background: #28a745; }
.status-cancelled { background: #dc3545; }

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<div class="dashboard-container">

    <!-- Welcome Banner -->
    <div class="dashboard-banner">
        <h2>Welcome back, {{ Auth::user()->name }} 👋</h2>
        <p>Manage your orders, wishlist, profile and more.</p>
    </div>

    <!-- Stats -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <i class="ri-shopping-bag-3-line stat-icon"></i>
            <h4>Total Orders</h4>
            <p>{{ $ordersCount ?? 0 }}</p>
        </div>

        <div class="stat-card">
            <i class="ri-heart-line stat-icon"></i>
            <h4>Wishlist Items</h4>
            <p>{{ $wishlistCount ?? 0 }}</p>
        </div>

        <div class="stat-card">
            <i class="ri-shopping-cart-2-line stat-icon"></i>
            <h4>Cart Items</h4>
            <p>{{ $cartCount ?? 0 }}</p>
        </div>

        <div class="stat-card">
            <i class="ri-user-settings-line stat-icon"></i>
            <h4>Profile Updated</h4>
            <p>{{ Auth::user()->updated_at->diffForHumans() }}</p>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="recent-orders-box">
        <h3>Recent Orders</h3>

        @if($recentOrders->isEmpty())
            <p style="color:#777;">You haven’t placed any orders yet.</p>
        @else
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>₦{{ number_format($order->amount) }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" style="color:#ac5b8c; font-weight:600;">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

</div>

@endsection
