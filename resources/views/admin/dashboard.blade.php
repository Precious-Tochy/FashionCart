@extends('layouts.admin layout')

@section('content')

<!-- DASHBOARD CARDS -->
<div class="dashboard-cards">
    <div class="card" style="background:#ac708e;">
        <h4>Total Orders</h4>
        <p>{{ $totalOrders }}</p>
    </div>
    <div class="card" style="background:#f0ad4e;">
        <h4>Pending Orders</h4>
        <p>{{ $pendingOrders }}</p>
    </div>
    <div class="card" style="background:#28a745;">
        <h4>Paid Orders</h4>
        <p>{{ $paidOrders }}</p>
    </div>
    <div class="card" style="background:#dc3545;">
        <h4>Cancelled Orders</h4>
        <p>{{ $cancelledOrders }}</p>
    </div>
    <div class="card" style="background:#007bff;">
        <h4>Total Revenue</h4>
        <p>₦{{ number_format($totalRevenue,2) }}</p>
    </div>
    <div class="card" style="background:#17a2b8;">
        <h4>Total Users</h4>
        <p>{{ $totalUsers }}</p>
    </div>
    <div class="card" style="background:#6f42c1;">
        <h4>Total Products</h4>
        <p>{{ $totalProducts }}</p>
    </div>
</div>

<!-- CHARTS -->
<div class="chart-container">
    <h4>Monthly Orders Overview</h4>
    <canvas id="ordersChart"></canvas>
</div>

<div class="chart-container">
    <h4>Monthly Revenue</h4>
    <canvas id="revenueChart"></canvas>
</div>

<style>
/* CARDS */
.dashboard-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}
.dashboard-cards p{
    font-size: 24px;
}


/* Default: 4 per row on desktop */
.dashboard-cards .card {
    flex: 1 1 calc(25% - 15px);
    padding: 18px;
    border-radius: 8px;
    color: #fff;
    min-width: 150px;
    box-sizing: border-box;
}

/* Tablet: 3 per row */
@media (max-width: 1024px) {
    .dashboard-cards .card {
        flex: 1 1 calc(33.33% - 15px);
    }
    .chart-container{
        height: 450px;;
    }
}

/* Phone: 2 per row */
@media (max-width: 768px) {
    .dashboard-cards .card {
        flex: 1 1 calc(50% - 15px);
    }
}

/* CHARTS */
.chart-container {
    margin-top: 50px;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    height: 500px;
    padding: 20px;
}

.chart-container canvas {
    width: 100% !important;
    height: 250px; /* reduced height for phone view */
}

/* Phone: reduce chart height slightly */
@media (max-width: 768px) {
    .chart-container canvas {
        height: 200px;
    }
    .chart-container{
        height: 400px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxOrders = document.getElementById('ordersChart').getContext('2d');
new Chart(ctxOrders, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [
            {
                label: 'Paid Orders',
                data: @json($paidData),
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            },
            {
                label: 'Cancelled Orders',
                data: @json($cancelledData),
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Orders per Month' }
        },
        scales: { y: { beginAtZero: true } }
    }
});

const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
new Chart(ctxRevenue, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Revenue',
            data: @json($revenueData),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Monthly Revenue' }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

@endsection
