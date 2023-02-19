<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vertical Navbar - Mazer Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}" />

    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}"
        type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}"
        type="image/png" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}" />
</head>

<body>
    <script src="{{ asset('assets/js/initTheme.js') }}"></script>
    <div id="app">
        {{-- Sidebar Start --}}
        @include('layouts.sidebar')
        <div id="main" class="layout-navbar navbar-fixed">
            {{-- Navbar Start --}}
            @include('layouts.navbar')
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>@yield('pageTitle')</h3>
                                {{-- <p class="text-subtitle text-muted">
                                    Navbar will appear on the top of the page.
                                </p> --}}
                            </div>
                            {{-- <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="index.html">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Layout Vertical Navbar
                                        </li>
                                    </ol>
                                </nav>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">@yield('contentTitle')</h4>
                        </div>
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </section>
                {{-- Footer Start --}}
                @include('layouts.footer')
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('assets/js/pages/datatables.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @include('layouts.sweetalert')
</body>

</html>
