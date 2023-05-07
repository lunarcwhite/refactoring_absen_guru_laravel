@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h2>Rekapan Presensi</h2>
@endsection
@section('content')
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    <form action="{{ route('dashboard.rekapan') }}" method="get">
                        <div class="form-group">
                            <label for="bulan">Inputkan Bulan dan Tahunnya Pada Inputan Dibawah</label>
                            <br />
                            <input type="month" name="bulan" id="bulan" class="form-control-month">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <div class="icon-box bg-primary">
                                <ion-icon name="search-circle-outline"></ion-icon>
                            </div>Tampilkan
                        </button>
                    </form>
                </div>
            </div>
            @if ($bulans !== null)
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <h2>Rekapan Absensi Bulan {{ $bulanIni }} Tahun {{ $tahunIni }}</h2>
                        <ul class="listview image-listview">
                            <li>
                                <div class="item">
                                    <div class="icon-box">
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>
                                            Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;<span>Status
                                                | &nbsp;</span><span>Jam Absen</span></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="listview image-listview">
                            @forelse ($bulans as $item)
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
                                                <span
                                                    class="badge badge-info">{{ $item->created_at->format('H:i:s') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <h1>Belum Ada Absen</h1>
                            @endforelse
                        </ul>
                    </div>

                </div>
            @endif
        </div>
    </div>
@stop
@push('js')
@endpush
