<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('project/css/list.css') }}">
</head>

<body>
    <div class="login">
        <div class="mr">
            <strong>LOG IN</strong>

            <p>ALREADY HAVE AN ACCOUNT WITH US? SIGN IN BELOW</p>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="email">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        placeholder="Email Address">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <i>Password must be 8 or more characters, including atleast one capital letter.</i>
                <br>
                <br>
                <div class="forgot">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" id="forgot-password">
                        Forget your Password
                    </a>
                    <br>
                    <br>
                @endif
                </div>
                <div class="small">

                    <p>
                    <div>
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    </p>
                </div>
                <br>

                <button type="submit">SIGN IN</button>

            </form>

        </div>
        <div class="mrs">

            <b>REGISTER</b>
            <p>NEW? CLICK BELOW TO REGISTER AND SET UP YOUR ACCOUNT. </p>
            <span>WHY CREATE AN ACCOUNT?</span>
            <ul>
                <li>Fast checkout with your details saved</li>
                <li>Track your orders and view order history</li>
                <li>Create and share your Wishlist</li>
                <li>Receive our latest news and offers</li>
            </ul>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="EM">
                    
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail Address">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br>
            
            <button type="submit">CREATE ACCOUNT</button>
        </div>
    </div>
</form>

</body>

</html>
