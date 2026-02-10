@extends('layouts.user layout')

@section('content')
@include('sweetalert::alert')


<style>
.edit-container {
    max-width: 850px;
    margin: 30px auto;
    padding: 30px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 7px 25px rgba(0,0,0,0.1);
    font-family: "Poppins", sans-serif;
}
.section-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #ac5b8c;
}
.input-group { margin-bottom: 18px; }
label { font-weight: 600; font-size: 14px; }
input, select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.save-btn, .danger-btn {
    padding: 12px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}
.save-btn { background:#ac5b8c; color:#fff; }
.danger-btn { background:#dc3545; color:#fff; margin-top:20px; }
</style>

<div class="edit-container">

    <div class="section-title">Edit Profile</div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="input-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}">
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}">
        </div>

        <div class="input-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $user->phone }}">
        </div>

        <div class="input-group">
            <label>Address</label>
            <input type="text" name="address" value="{{ $user->address }}">
        </div>

        <div class="input-group">
            <label>Gender</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="input-group">
            <label>Profile Photo</label>
            <input type="file" name="photo">
        </div>

        <button class="save-btn">Save Changes</button>
    </form>

    <hr style="margin:30px 0;">

    <!-- Change Password Section -->
    <div class="section-title">Change Password</div>

    <form action="{{ route('profile.password') }}" method="POST">
        @csrf

        <div class="input-group">
            <label>Current Password</label>
            <input type="password" name="current_password">
        </div>

        <div class="input-group">
            <label>New Password</label>
            <input type="password" name="new_password">
        </div>

        <div class="input-group">
            <label>Confirm New Password</label>
            <input type="password" name="new_password_confirmation">
        </div>

        <button class="save-btn">Change Password</button>
    </form>

    <hr style="margin:30px 0;">

    <!-- Delete Account -->
    <div class="section-title">Delete Account</div>

    <form action="{{ route('profile.delete') }}" method="POST">
        @csrf
        <button class="danger-btn" onclick="return confirm('Are you sure? This cannot be undone.')">
            Delete My Account
        </button>
    </form>

</div>

@endsection
