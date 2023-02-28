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
                <h1 class="auth-title mt-5">New Password</h1>
            <p class="auth-subtitle mb-5">
              Input your new password.
            </p>
                <form action="{{route('resetPasswordProcess')}}" method="post">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl" placeholder="New Password" name="password" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <input type="hidden" name="token" value="{{ $token }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                        Change
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.sweetalert')
</body>

</html>
