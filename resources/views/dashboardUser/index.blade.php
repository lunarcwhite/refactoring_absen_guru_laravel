@extends('layouts.dashboardUser')
@section('pageTitle')
    Dashboard
@endsection
@section('content')
    <!-- App Capsule -->
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                @if(Auth::user()->photo !== null)
                <img src="{{asset('storage/photo_profile/'.Auth::user()->photo)}}" alt="avatar" class="imaged w64 rounded">
                @else
                <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{Auth::user()->nama}}</h2>
                <span id="user-role">{{Auth::user()->email}}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{route('dashboard.profile')}}" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profile</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{route('dashboard.rekapan')}}" class="info" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{route('dashboard.presensi.izin')}}" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Izin</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="danger" style="font-size: 40px;">
                                <ion-icon name="log-out"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Log Out</span>
                        </div>
                    </div>
                    <form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absenHariIni !== null)
                                        @php
                                            $masuk = Storage::url('swafoto_absensi_masuk/' . $absenHariIni->created_at->format('Y-m-d') . '/' . $absenHariIni->absen_masuk);
                                        @endphp
                                        <img src="{{ url($masuk) }}" alt="" width="60px" height="40px">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $absenHariIni !== null ? $absenHariIni->created_at->format('H:i:s') : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absenHariIni !== null && $absenHariIni->absen_pulang !== null)
                                        @php
                                            $pulang = Storage::url('swafoto_absensi_pulang/' . $absenHariIni->created_at->format('Y-m-d') . '/' . $absenHariIni->absen_pulang);
                                        @endphp
                                        <img src="{{ url($pulang) }}" alt="" width="60px" height="40px">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $absenHariIni !== null && $absenHariIni->absen_pulang !== null ? $absenHariIni->updated_at->format('H:i:s') : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rekappresence">
            {{-- <div id="chartdiv"></div> --}}
            <h2>Rekap Absensi Bulan {{ $namaBulan[$bulanIni * 1] }} Tahun {{ $tahunIni }}</h2>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence primary">
                                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Hadir</h4>
                                    <span class="rekappresencedetail">{{ $absenBulanIni->count() }} Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence green">
                                    <ion-icon name="document-text"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Izin</h4>
                                    <span class="rekappresencedetail">0 Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence warning">
                                    <ion-icon name="sad"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Sakit</h4>
                                    <span class="rekappresencedetail">0 Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence danger">
                                    <ion-icon name="alarm"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Terlambat</h4>
                                    @php
                                        $terlambat = 0;
                                        foreach ($absenBulanIni as $key => $value) {
                                            $value->created_at->format('H:i:s') > '08:00:00' ? ($terlambat += 1) : ($terlambat += 0);
                                        }
                                    @endphp
                                    <span class="rekappresencedetail">{{ $terlambat }} Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <h5 class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </h5>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item">
                                <div class="icon-box">
                                    <ion-icon name="bookmark-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<span>Status
                                            | &nbsp;</span><span>Jam Absen</span></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($historiBulanIni as $item)
                            <li>
                                <div class="item">
                                    @if ($item->created_at->format('H:i:s') < '08:00:00')
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                                        </div>
                                    @else
                                        <div class="icon-box bg-danger">
                                            <ion-icon name="alarm-outline"></ion-icon>
                                        </div>
                                    @endif
                                    <div class="in">
                                        <div>{{ $item->created_at->format('d-m-Y') }} &nbsp;
                                            @if ($item->created_at->format('H:i:s') < '08:00:00')
                                                <span class="badge badge-success">Hadir</span>
                                            @else
                                                <span class="badge badge-danger">Terlambat</span>
                                            @endif
                                            &nbsp;
                                            <span class="badge badge-info">{{ $item->created_at->format('H:i:s') }}</span>
                                        </div>
                                    </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- * App Capsule -->
@stop
@push('js')
    <script>
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chartdiv", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.legend = new am4charts.Legend();

            chart.data = [{
                    country: "Hadir",
                    litres: 501.9
                },
                {
                    country: "Sakit",
                    litres: 301.9
                },
                {
                    country: "Izin",
                    litres: 201.1
                },
                {
                    country: "Terlambat",
                    litres: 165.8
                },
            ];



            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "litres";
            series.dataFields.category = "country";
            series.alignLabels = false;
            series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
            series.labels.template.radius = am4core.percent(-40);
            series.labels.template.fill = am4core.color("white");
            series.colors.list = [
                am4core.color("#1171ba"),
                am4core.color("#fca903"),
                am4core.color("#37db63"),
                am4core.color("#ba113b"),
            ];
        }); // end am4core.ready()
    </script>
@endpush
