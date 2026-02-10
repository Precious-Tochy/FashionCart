<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\Dress;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Show all users except current admin
    public function users()
    {
        $currentUser = Auth::user();
        $users = User::where('id', '!=', $currentUser->id)->get();
        return view('admin.users', compact('users'));
    }

    public function deleteuser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Alert::success('Success', 'User Deleted Successfully');
        return redirect()->back();
    }

    public function banned_status($id)
    {
        $user = User::findOrFail($id);
        $user->banned_status = 1;
        $user->save();
        Alert::success('Success', 'User Banned Successfully');
        return redirect()->back();
    }

    public function unbanned_status($id)
    {
        $user = User::findOrFail($id);
        $user->banned_status = 0;
        $user->save();
        Alert::success('Success', 'User Unbanned Successfully');
        return redirect()->back();
    }

    // Show all orders (with optional filters)
    // Show all orders
public function orders(Request $request)
{
    $query = Order::query();

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    $orders = $query->latest()->paginate(20);

    // Adjust view path to match your structure
    return view('admin.orders', compact('orders'));
}

// Show single order
public function viewOrder($id)
{
    $order = Order::with('items')->findOrFail($id);

    // Adjust view path to match your structure
    return view('admin.show', compact('order'));
}


    // View single order details
    

    // Update order status
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        Alert::success('Success', 'Order status updated');
        return back();
    }

    // Admin dashboard
   
    

public function dashboard()
{
    $totalOrders = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $paidOrders = Order::where('status', 'paid')->count();
    $cancelledOrders = Order::where('status', 'cancelled')->count();

    $totalUsers = User::count();
    $totalProducts = Dress::count();

    // Total Revenue from paid orders
    $totalRevenue = Order::where('status', 'paid')->sum('amount');

    // Labels for months
    $labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    $year = now()->year;

    // Number of paid orders per month
    $paidData = [];
    for ($m = 1; $m <= 12; $m++) {
        $paidData[] = Order::where('status', 'paid')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $m)
            ->count();
    }

    // Revenue per month (from paid orders)
    $revenueData = [];
    for ($m = 1; $m <= 12; $m++) {
        $revenueData[] = Order::where('status', 'paid')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $m)
            ->sum('amount');
    }

    // Cancelled orders per month
    $cancelledData = [];
    for ($m = 1; $m <= 12; $m++) {
        $cancelledData[] = Order::where('status', 'cancelled')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $m)
            ->count();
    }

    return view('admin.dashboard', compact(
        'totalOrders', 'pendingOrders', 'paidOrders', 'cancelledOrders',
        'totalUsers', 'totalProducts', 'totalRevenue', 'labels', 'paidData', 'revenueData', 'cancelledData'
    ));
}

}
