<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Dress;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Show wishlist
    public function index()
    {
        if (Auth::check()) {
            // Logged-in user
            $wishlists = Wishlist::where('user_id', Auth::id())->pluck('dress_id')->toArray();
            $dresses = Dress::whereIn('id', $wishlists)->get();

            // Load the user-wishlist blade
            return view('user.user-wishlist', compact('dresses'));
        } else {
            // Guest user - use session
            $wishlist = session()->get('wishlist', []);
            $dresses = Dress::whereIn('id', $wishlist)->get();

            // Load the guest wishlist blade
            return view('wishlist', compact('dresses'));
        }
    }

    // Add a dress to wishlist
    public function add(Dress $dress)
    {
        if (Auth::check()) {
            Wishlist::firstOrCreate([
                'user_id' => Auth::id(),
                'dress_id' => $dress->id
            ]);
            return response()->json(['status' => 'added', 'guest' => false]);
        } else {
            $wishlist = session()->get('wishlist', []);
            if (!in_array($dress->id, $wishlist)) {
                $wishlist[] = $dress->id;
                session(['wishlist' => $wishlist]);
            }
            return response()->json(['status' => 'added', 'guest' => true]);
        }
    }

    // Remove a dress from wishlist
    public function remove(Dress $dress)
    {
        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())
                ->where('dress_id', $dress->id)
                ->delete();
            return response()->json(['status' => 'removed', 'guest' => false]);
        } else {
            $wishlist = session()->get('wishlist', []);
            $wishlist = array_filter($wishlist, fn($id) => $id != $dress->id);
            session(['wishlist' => $wishlist]);
            return response()->json(['status' => 'removed', 'guest' => true]);
        }
    }
}
