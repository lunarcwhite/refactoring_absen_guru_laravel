@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h2>Presensi</h2>
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
                    @if ($izinHariIni > 0)
                        <h1>@php
                            echo 'Tanggal ' . date('Y-m-d');
                        @endphp</h1>
                        <h1>Kamu Sudah Melakukan Pengajuan Untuk Tidak Hadir</h1>
                        <h2>Silahkan Lihat <a href="{{route('dashboard.presensi.izin')}}">Disini</a></h2>
                    @else
                    @if ($pulang !== null && $absen > 0)
                        <h1>@php
                            echo date('Y-m-d');
                        @endphp</h1>
                        <h1>Kamu Sudah Melakukan Absen</h1>
                    @else
                        @if ($absen > 0)
                            <form action="{{ route('dashboard.presensi.absen.pulang') }}" method="post" id="absen"
                                enctype="multipart/form-data">
                                @method('patch')
                            @else
                                <form action="{{ route('dashboard.presensi.absen.masuk') }}" method="post" id="absen"
                                    enctype="multipart/form-data">
                        @endif
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="lokasi" name="lokasi" class="form-control">
                            <label for="captureimage"></label>
                            <input type="file" name="swafoto" class="form-control-file" id="captureimage" capture="user" accept="image/*"
                                class="form-control">
                        </div>
                        <div id="imagewrapper">
                            <img id="showimage" preload="none" autoplay="autoplay" src="#" width="80%"
                                height="auto">
                            <!--there would be a videoposter attribute, but that causes the issue on iOS that the video has no preview when it's done with loading... poster="https://i.imgur.com/JjqzFvI.png" -->
                        </div>
                        @if ($absen > 0)
                            <button class="btn btn-secondary mt-2 btn-lg btn-block" type="button"
                                onclick="konfirmasiAbsen()">Absen Pulang
                            </button>
                        @else
                            <button class="btn btn-primary mt-2 btn-lg btn-block" type="button"
                                onclick="konfirmasiAbsen()">Absen Masuk
                            </button>
                        @endif
                        </form>
                    @endif
                    @endif
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
            var circle = L.circle([-6.88456, 107.57407], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 100
            }).addTo(map);
        }

        function errorCallback() {
            Swal.fire(
                'Kamu Harus Mengizinkan Aplikasi Untuk Mengakses GPS!',
                'That thing is still around?',
                'info'
            )
        }

        function konfirmasiAbsen() {
            let form = event.target.form;
            @if ($absen > 0)
                Swal.fire({
                    html: "Kamu Akan Melakukan <h2>Absen Pulang!</h2>",
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
            @else
                Swal.fire({
                    html: "Kamu Akan Melakukan <h2>Absen Masuk!</h2>",
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
            @endif
        };
    </script>
@endpush
