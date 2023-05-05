@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h1>Rekapan Presensi</h1>
@endsection
@section('content')
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    <form action="{{ route('dashboard.rekapan') }}" method="get">
                        <div class="form-group">
                            <label for="bdaymonth">Birthday (month and year):</label>
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
                <div class="row">
                    <div class="col">
                        <div class="tab-content mt-2" style="margin-bottom:100px;">
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                                <h2>Rekapan Absensi Bulan {{ $bulanIni }} Tahun {{ $tahunIni }}</h2>
                                <ul class="listview image-listview">
                                    @forelse ($bulans as $bulan)
                                        <li>
                                            <div class="item">
                                                <div class="icon-box bg-primary">
                                                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                                                </div>
                                                <div class="in">
                                                    {{ $bulan->created_at->format('d-m-Y') }} <span
                                                            class="badge badge-success">Hadir</span>
                                                        @if ($bulan->created_at->format('H:i:s') > '08:00:00')
                                                            <span class="badge badge-danger">
                                                                Terlambat
                                                            </span>
                                                        @endif
                                                        <span
                                                            class="badge badge-info">{{ $bulan->created_at->format('H:i:s') }}</span>
                                                    
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <h1>Belum Ada Absen</h1>
                                    @endforelse
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop
@push('js')
@endpush
