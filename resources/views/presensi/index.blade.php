@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h1>Presensi</h1>
    <style>

    </style>
@endsection
@section('content')
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="lokasi" name="lokasi" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="file" name="photo" id="captureimage" capture="user" accept="image/*" class="form-control">
                        </div>
                        <div id="imagewrapper">
                            <image id="showimage" preload="none" autoplay="autoplay" src="#" width="80%"
                            height="auto"></image>
                            <!--there would be a videoposter attribute, but that causes the issue on iOS that the video has no preview when it's done with loading... poster="https://i.imgur.com/JjqzFvI.png" -->
                        </div>
                        <button class="btn btn-primary mt-2 justify-content-center" type="submit"><ion-icon name="checkmark-done-outline"></ion-icon>Absen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#showimage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#captureimage").change(function() {
            readURL(this);
        });
        let lokasi = document.getElementById('lokasi');
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        }

        function errorCallback() {

        }
    </script>
@endpush
