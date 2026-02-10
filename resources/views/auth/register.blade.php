@extends('layouts.legister layout')
@section('content')




    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Ify's Fashion World</title>
    <link rel="stylesheet" href="{{ asset('project/css/register.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

    <!-- Registration Form -->
    <main class="register-container">
        <div class="form-box">
            <h2>Create Your Account</h2>
            <p class="subtitle">Join Ify's Fashion for a refined shopping experience</p>

            <form method="POST" action="{{ route('register') }}">
                        @csrf

                <div class="form-group">
                    <label for="fullname">Full Name</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                        placeholder="Enter your full name" required>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror



                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" placeholder="Enter your password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password" placeholder="Confirm your password" required>

                    
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="newsletter">
                    <label for="newsletter">Subscribe to our newsletter for exclusive updates</label>
                </div>

                <button type="submit" class="btn">Register</button>

                <p class="login-link">Already have an account? <a href="{{route('login')}}">Login here</a></p>
            </form>
        </div>
    </main>

    <!-- Footer -->
    
@endsection