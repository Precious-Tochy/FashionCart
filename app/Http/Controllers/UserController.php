<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    // Show profile
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Edit profile page
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit_profile', compact('user'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'gender' => 'nullable',
            'address' => 'nullable',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // Update details
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->address = $request->address;

        // Allow email update only if needed
        if ($request->email) {
            $user->email = $request->email;
        }

        // Image Upload
        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/profile'), $imageName);
            $user->photo = $imageName;
        }

        $user->save();

        Alert::success('Profile Updated', 'Your profile has been updated successfully.');

        return redirect()->route('profile');
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            Alert::error('Error', 'Current password is incorrect.');
            return back();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Alert::success('Password Updated', 'Your password was changed successfully.');
        return redirect()->route('profile');
    }

    // Delete Account
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $user->delete();

        Alert::success('Account Deleted', 'Your account has been removed.');
        return redirect('/');
    }
   


}
