@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h2>Presensi</h2>
    <style>
        #map {
            height: 250px;
        }

        .file {
            visibility: hidden;
            position: absolute;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
@endsection
@section('content')
    <div class="section full mt-2  mb-5">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    @if ($hari->status == 0)
                        <h2>@php echo 'Tanggal ' . date('Y-m-d'); @endphp</h2>
                        <h3>Hari Senin Anda Tidak Memiliki Jadwal Absen </h3>
                    @else
                        @if ($absen != null && $absen->status_absensi == 5)
                            <h2>@php echo 'Tanggal ' . date('Y-m-d'); @endphp</h2>
                            <h5>Hari Ini Absensi Libur </h5>
                        @elseif($absen != null && $absen->status_absensi == 6)
                            <h2>@php echo 'Tanggal ' . date('Y-m-d'); @endphp</h2>
                            <h5>Hari Ini Tidak Ada Jadwal Absensi</h5>
                        @else
                            @if ($absen != null && $absen->status_absensi != 7 && $absen->absen_masuk == null)
                                <h2>@php echo 'Tanggal ' . date('Y-m-d'); @endphp</h2>
                                <h5>Kamu Sudah Melakukan Pengajuan Untuk Tidak Hadir </h5>
                                <h5>Status Pengajuan <span class="badge bg-success">Disetujui</span></h5>
                                <h6><a href="{{ route('dashboard.presensi.izin') }}">Silahkan Lihat Disini</a></h6>
                            @else
                                @if ($izinHariIni != null)
                                    @if ($izinHariIni->status_approval == 2)
                                        <h2>@php echo 'Tanggal ' . date('Y-m-d'); @endphp</h2>
                                        <h5>Kamu Sudah Melakukan Pengajuan Untuk Tidak Hadir </h5>
                                        <h5>Status Pengajuan <span class="badge bg-warning">Pending</span></h5>
                                        <h5>Silahkan Hubungi Admin Untuk Konfirmasi</h5>
                                        <h5 class="text-danger">Melakukan Absensi Akan Menghapus Data Pengajuan</h5>
                                    @elseif ($absen != null && $absen->status_absensi == 7 && $izinHariIni->status_approval == 0)
                                        <h2>@php echo 'Tanggal ' . date('Y-m-d'); @endphp</h2>
                                        <h5>Kamu Sudah Melakukan Pengajuan Untuk Tidak Hadir </h5>
                                        <h5>Status Pengajuan <span class="badge bg-danger">Ditolak</span></h5>
                                        <h5>Silahkan Hubungi Admin Untuk Konfirmasi</h5>
                                        <h5 class="text-danger">Melakukan Absensi Akan Menghapus Data Pengajuan</h5>
                                    @endif
                                @endif
                                @if ($pulang !== null && $absen != null && $absen->status_absensi != 7)
                                    <h1>@php
                                        echo date('Y-m-d');
                                    @endphp</h1>
                                    <h1>Kamu Sudah Melakukan Absen</h1>
                                @else
                                    <form action="{{ route('dashboard.presensi.absen.store') }}" method="post"
                                        id="absen" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" id="lokasi" name="lokasi" class="form-control">
                                        </div>
                                        <div class="form-group boxed">
                                            <input type="file" name="swafoto" class="file image-input" accept="image/*"
                                                capture="user">
                                            <div class="input-group">
                                                <input type="text" class="form-control image-filename" disabled
                                                    placeholder="Ambil Swafoto" id="file">
                                                <div class="input-group-append">
                                                    <button type="button" class="browse btn btn-primary">Klik
                                                        Disini</button>
                                                </div>
                                            </div>
                                            <div class="image-preview col-sm-12 col-md-6 mt-1">

                                            </div>
                                        </div>
                                        @if (($absen != null && $absen->status_absensi != 7) || ($absen != null && $absen->status_absensi == 1))
                                            <button class="btn btn-secondary mt-2 btn-lg btn-block" type="button"
                                                onclick="konfirmasiAbsen()">Absen
                                                Pulang
                                            </button>
                                        @else
                                            <button class="btn btn-primary mt-2 btn-lg btn-block" type="button"
                                                onclick="konfirmasiAbsen()">Absen
                                                Masuk
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            @endif
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
                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();
                };

                reader.readAsDataURL(input.files[0]);

            }
        }

        let lokasi = document.getElementById('lokasi');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            if (`{{ $lokasi->status === '1' }}`) {
                var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
                let koordinat = '{{ $lokasi->lokasi }}';
                let lokasiAbsen = koordinat.split(',');
                var circle = L.circle([lokasiAbsen[0], lokasiAbsen[1]], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: '{{ $lokasi->radius }}'
                }).addTo(map);
            }
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
            @if ($absen != null && $absen->status_absensi != 7)
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
        $(document).on("click", ".browse", function() {
            $('.image-preview').empty();
            var file = $(this).parents().find(".file");
            file.trigger("click");
        });
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $("#file").val(fileName);

            var reader = new FileReader();
            reader.onload = function(e) {
                // get loaded data and render thumbnail.
                $('.image-preview').append(
                    `<button type="button" class="close bg-danger" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button><img src="https://placehold.it/80x80" id="preview" class="img-thumbnail">`
                );
                document.getElementById("preview").src = e.target.result;
            };
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        });
        $(document).on("click", ".close", function() {
            $('.image-preview').empty();
            $("#file").val("");
            $(".file").val("");
        });
    </script>
@endpush
