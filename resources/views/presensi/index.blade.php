@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h1>Presensi</h1>
    <style>
        #map {
            height: 250px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
@endsection
@section('content')
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    <form action="{{ route('dashboard.user.presensi.absen') }}" method="post" id="absen" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="lokasi" name="lokasi" class="form-control">
                            <input type="file" name="swafoto" id="captureimage" capture="user" accept="image/*"
                                class="form-control">
                        </div>
                        <div id="imagewrapper">
                            <image id="showimage" preload="none" autoplay="autoplay" src="#" width="80%"
                                height="auto"></image>
                            <!--there would be a videoposter attribute, but that causes the issue on iOS that the video has no preview when it's done with loading... poster="https://i.imgur.com/JjqzFvI.png" -->
                        </div>
                        <button class="btn btn-primary mt-2 justify-content-center" type="button"
                            onclick="konfirmasiAbsen()">
                            <ion-icon name="checkmark-done-outline"></ion-icon>Absen
                        </button>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <div id="map"></div>
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
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 70
            }).addTo(map);
        }

        function errorCallback() {

        }

        function konfirmasiAbsen() {
            let form = event.target.form;
            Swal.fire({
                text: "Kamu Akan Melakukan Absen!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Absen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        };

    </script>
@endpush
