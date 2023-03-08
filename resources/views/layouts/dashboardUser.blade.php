<!doctype html>
<html lang="en">

@include('layouts.headerUser')

<body style="background-color:#e9ecef;">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Capsule -->
    <div id="appCapsule">
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
