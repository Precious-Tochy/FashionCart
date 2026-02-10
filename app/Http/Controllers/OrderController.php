<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    // Show all orders
    public function index()
    {
        $orders = Order::latest()->paginate(20);
        // View is directly in admin folder
        return view('admin.orders', compact('orders'));
    }

    // Show pending orders
    public function pending()
    {
        $orders = Order::where('status', 'pending')->latest()->paginate(20);
        return view('admin.orders', compact('orders')); // same view, filtered in controller
    }

    // Show paid orders
    public function paid()
    {
        $orders = Order::where('status', 'paid')->latest()->paginate(20);
        return view('admin.orders', compact('orders')); // same view
    }

    // View single order + its items
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.view_order', compact('order')); // save your single order view as view_order.blade.php
    }

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }

    // Delete order
    public function delete($id)
    {
        Order::findOrFail($id)->delete();
        return back()->with('success', 'Order deleted successfully.');
    }
    public function userOrders()
{
    $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->get();
    return view('user.orders', compact('orders'));
}

public function userOrderDetails($id)
{
    $order = \App\Models\Order::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
    return view('user.order-details', compact('order'));
}

}
