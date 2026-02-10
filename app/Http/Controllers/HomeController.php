<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use App\Models\Dress;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userType = Auth::user()->userType;
        $banned_status = Auth::user()->banned_status;

        if ($userType == 0 && $banned_status == 0) {
   $user = Auth::user();
$recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();
$ordersCount = Order::where('user_id', $user->id)->count();
$wishlistCount = $user->wishlists()->count();
$cartCount = $user->cartItems()->count(); // assuming you have a Cart model/relation

return view('user.dashboard', compact('recentOrders', 'ordersCount', 'wishlistCount', 'cartCount'));

}

         elseif ($userType == 1 && $banned_status == 0) {

            // ===== Dashboard Variables =====
            $totalOrders = Order::count();
            $pendingOrders = Order::where('status', 'pending')->count();
            $paidOrders = Order::where('status', 'paid')->count();
            $cancelledOrders = Order::where('status', 'cancelled')->count();
            $totalRevenue = Order::where('status', 'paid')->sum('amount');
            $totalUsers = User::count();
            $totalProducts = Dress::count();

            // ===== Monthly Chart Data =====
            $labels = [];
            $paidData = [];
            $cancelledData = [];
            $revenueData = [];

            for ($i = 1; $i <= 12; $i++) {
                $monthName = date('F', mktime(0, 0, 0, $i, 1));
                $labels[] = $monthName;

                $paidData[] = Order::where('status', 'paid')
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', date('Y'))
                    ->count();

                $cancelledData[] = Order::where('status', 'cancelled')
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', date('Y'))
                    ->count();

                $revenueData[] = Order::where('status', 'paid')
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', date('Y'))
                    ->sum('amount');
            }

            return view('admin.dashboard', compact(
                'totalOrders',
                'pendingOrders',
                'paidOrders',
                'cancelledOrders',
                'totalRevenue',
                'totalUsers',
                'totalProducts',
                'labels',
                'paidData',
                'cancelledData',
                'revenueData'
            ));
        } else {
            return view('auth.login');
        }
    }
    
}
