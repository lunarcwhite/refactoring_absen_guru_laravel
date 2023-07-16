<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Mobilekit Mobile UI Kit</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="{{asset('assets_mobile/img/favicon.png')}}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets_mobile/img/icon/192x192.png')}}">
    <link rel="stylesheet" href="{{asset('assets_mobile/css/style.css')}}">
    <link rel="manifest" href="{{asset('__manifest.json')}}">
    <style>
        .file {
            visibility: hidden;
            position: absolute;
        }
        body.dark-mode-active h3{
            color: black;
        }
    </style>
</head>

<body>
    <form action="{{ route('logout') }}" method="post" id="form-logout">
        @csrf
    </form>
    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <div id="not_dashboard">
                <div class="android-detection ios-detection">
                    <a href="javascript:;" class="headerButton goBack">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    </a>
                </div>
            </div>
            <div class="non-mobile-detection">
                <a href="index.html#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                    <ion-icon name="menu-outline"></ion-icon>
                </a>
            </div>
        </div>
        <div class="pageTitle">
            @yield('pageTitle')
        </div>
        <div class="right">
            <div class="android-detection ios-detection">
                @yield('pageRightButton')
            </div>
            {{-- <a href="javascript:;" class="headerButton toggle-searchbox">
                <ion-icon name="search-outline"></ion-icon>
            </a> --}}
        </div>
    </div>
    <!-- * App Header -->

    {{-- <!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <a href="javascript:;" class="ml-1 close toggle-searchbox">
                    <ion-icon name="close-circle"></ion-icon>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component --> --}}

    <!-- App Capsule -->
   <div id="appCapsule">

        <div class="header-large-title">
            <h1 class="title">@yield('pageTitle')</h1>
            <h4 class="subtitle">@yield('pageSubTitle')</h4>
        </div>
        @yield('content')
        <!-- app footer -->
        @include('layouts.dashboard_mobile.partial.footer')
        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @include('layouts.dashboard_mobile.partial.navbar')
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    {{-- @include('layouts.dashboard_mobile.partial.sidebar') --}}
    <!-- * App Sidebar -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- Bootstrap-->
    <script src="{{asset('assets_mobile/js/lib/popper.min.js')}}"></script>
    <script src="{{asset('assets_mobile/js/lib/bootstrap.min.js')}}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{asset('assets_mobile/js/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
    <!-- Base Js File -->
    <script src="{{asset('assets_mobile/js/base.js')}}"></script>
@include('layouts.scripts.sweetalert')
@include('layouts.scripts.image-preview-js')
    @stack('js')


</body>

</html>