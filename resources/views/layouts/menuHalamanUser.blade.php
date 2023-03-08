<!doctype html>
<html lang="en">

@include('layouts.headerUser')

<body>

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{url()->previous()}}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">@yield('pageTitle')</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->

    <div id="appCapsule">
        {{-- Position your content is here --}}
        @yield('content')
    </div>
    <!-- * App Capsule -->

    <!-- App Bottom Menu -->
    @include('layouts.bottomMenuUser')
    @include('layouts.scriptsUser')

    @include('layouts.sweetalert')
    @stack('js')

</body>

</html>