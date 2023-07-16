@extends('layouts.dashboard_mobile.master')
@section('pageTitle')
    Dashboard
@endsection
@section('content')
    <!-- App Capsule -->
    <div class="section">
        <div id="user-detail">
            <div class="avatar">
                @if(Auth::user()->photo !== null)
                <img src="{{asset('storage/photo_profile/'.Auth::user()->photo)}}" alt="avatar" class="imaged w64 rounded">
                @else
                <img src="{{ asset('assets_mobile/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{Auth::user()->username}}</h2>
                <span id="user-role">{{Auth::user()->email}}</span>
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
                                    @if ($absenHariIni !== null && $absenHariIni->photo_absen_masuk !== null)
                                        @php
                                            $masuk = Storage::url('swafoto_absensi_masuk/' . $absenHariIni->created_at->format('Y-m-d') . '/' . $absenHariIni->photo_absen_masuk);
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
                                    @if ($absenHariIni !== null && $absenHariIni->photo_absen_pulang !== null)
                                        @php
                                            $pulang = Storage::url('swafoto_absensi_pulang/' . $absenHariIni->created_at->format('Y-m-d') . '/' . $absenHariIni->photo_absen_pulang);
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
<hr/>
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
                                    <span class="rekappresencedetail">{{ $historiBulanIni->where('status_absensi', "1")->count() }} Hari</span>
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
                                    <span class="rekappresencedetail">{{$izinBulanIni->count()}} Hari</span>
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
                                <div class="iconpresence danger">
                                    <ion-icon name="sad"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Alfa</h4>
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
                                <div class="iconpresence warning">
                                    <ion-icon name="alarm"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="rekappresencetitle">Terlambat</h4>
                                    @if($jam !== null)
                                                                        @php
                                        $terlambat = 0;
                                        foreach ($historiBulanIni->where('status_absensi', "1") as $key => $value) {
                                            $value->created_at->format('H:i:s') > $jam->jam ? ($terlambat += 1) : ($terlambat += 0);
                                        }
                                    @endphp
                                    <span class="rekappresencedetail">{{ $terlambat }} Hari</span>
                                    @endif
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
            <div class="tab-content" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped display nowrap">
                            <thead>
                                <th>Tanggal Absen</th>
                                <th>Status Absen</th>
                                <th>Jam Absen Masuk</th>
                            </thead>
                            <tbody>
                                @forelse ($historiBulanIni as $no => $item)
                                    <tr>
                                        <td>{{ $item->tanggal_absensi }}</td>
                                        <td>
                                            @if ($item->status_absensi === '2')
                                                <span class="badge badge-info">Cuti</span>
                                            @elseif($item->status_absensi === '3')
                                                <span class="badge badge-info">Sakit</span>
                                            @elseif($item->status_absensi === '4')
                                                <span class="badge badge-info">Izin</span>
                                            @elseif($item->status_absensi === '5')
                                                <span class="badge badge-success">Hari Libur</span>
                                            @elseif($item->status_absensi === '6')
                                                <span class="badge badge-secondary">Tidak Ada Jadwal</span>
                                            @elseif($item->status_absensi === '7')
                                                <span class="badge badge-secondary">Pengajuan Izin
                                                    Ditolak</span>
                                            @elseif($item->status_absensi === '1')
                                                @if ($item->created_at->format('H:i:s') < '08:00:00')
                                                    <span class="badge badge-success">Hadir</span>
                                                @else
                                                    <span class="badge badge-warning">Terlambat</span>
                                                @endif
                                            @else
                                                <span class="badge badge-danger">Alfa</span>
                                            @endif
                                        </td>
                                        <td><span class="badge badge-info">{{ $item->created_at->format('H:i:s') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <h1>Belum Ada Absen</h1>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
@stop