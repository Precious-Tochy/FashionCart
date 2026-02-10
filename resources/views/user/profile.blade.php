@extends('layouts.user layout')

@section('content')
@include('sweetalert::alert')

<style>
/* ===== Modern Profile UI ===== */

body {
    font-family: "Poppins", sans-serif;
}

/* Wrapper */
.profile-wrapper {
    max-width: 900px;
    margin: 30px auto;
    padding: 0 15px;
}

/* Glassmorphic Card */
.profile-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 15px 45px rgba(0,0,0,0.08);
    animation: fadeIn 0.6s ease-in-out;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Profile Header */
.profile-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 25px;
}

.profile-photo {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ac5b8c;
    box-shadow: 0 5px 20px rgba(172, 91, 140, 0.3);
}

/* Name + Email Section */
.profile-info h2 {
    font-size: 26px;
    font-weight: 700;
    color: #333;
}

.profile-info p {
    color: #555;
    margin-top: 5px;
}

/* Edit Button */
.edit-btn {
    padding: 12px 20px;
    background: #ac5b8c;
    color: #fff !important;
    border-radius: 10px;
    display: inline-block;
    margin-top: 12px;
    transition: 0.3s;
    font-weight: 500;
}

.edit-btn:hover {
    background: #8c4672;
    transform: translateY(-2px);
}

/* Section Title */
.section-title {
    margin-top: 35px;
    font-size: 20px;
    font-weight: 700;
    color: #ac5b8c;
}

/* Contact List */
.profile-details p {
    font-size: 15px;
    color: #444;
    margin: 10px 0;
}

.profile-details strong {
    width: 120px;
    display: inline-block;
    color: #000;
}

/* Responsive */
@media (max-width: 600px) {
    .profile-header {
        text-align: center;
        flex-direction: column;
    }
    .profile-info h2 {
        font-size: 22px;
    }
}
</style>


<div class="profile-wrapper">
    <div class="profile-card">

        <div class="profile-header">
            <img src="{{ $user->photo ? asset('uploads/profile/'.$user->photo) : asset('default.png') }}" 
                 class="profile-photo">

            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>

                <a href="{{ route('profile.edit') }}" class="edit-btn">Edit Profile</a>
            </div>
        </div>

        <div class="profile-details">
            <h3 class="section-title">Contact Information</h3>

            <p><strong>Phone:</strong> {{ $user->phone ?? 'Not added' }}</p>
            <p><strong>Address:</strong> {{ $user->address ?? 'Not added' }}</p>
            <p><strong>Gender:</strong> {{ $user->gender ?? 'Not set' }}</p>
        </div>

    </div>
</div>

@endsection
