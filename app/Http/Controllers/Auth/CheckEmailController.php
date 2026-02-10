<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CheckEmailController extends Controller
{
    public function showForm()
    {
        return view('auth.check-email');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // If user exists -> log them in
        if (User::where('email', $email)->exists()) {
            // redirect to login form (or dashboard directly if you want)
            return redirect()->route('login')->withInput(['email' => $email]);
        }

        // If not exists -> redirect to register form with email prefilled
        return redirect('/register')->withInput(['email' => $email]);

    }
}
