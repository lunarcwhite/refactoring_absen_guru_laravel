<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vertical Navbar - Mazer Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}" />

    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}"
        type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}"
        type="image/png" />
</head>

<body>
<div id="auth">
    <div class="row h-100">
        <div class="col-12">
            <div id="auth-left">
                <h1 class="auth-title">Register.</h1>
                <p class="auth-subtitle mb-3">
                    Register with your data to create the account.
                </p>
                <form id="registration" action="{{route('registration')}}" method="post">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl" placeholder="Username" name="username" />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" />
                        <div class="form-control-icon">
                            <i class="bi bi-voicemail"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
                        Register
                    </button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">
                        Already have an account?
                        <a href="{{route('login')}}" class="font-bold">Sign in</a>.
                    </p>
                    <p>
                        <a class="font-bold" href="{{route('forgotPassword')}}">Forgot password?</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.sweetalert')
</body>

</html>
