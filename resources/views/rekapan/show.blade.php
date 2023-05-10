@extends('layouts.dashboardAdmin')
@section('title')
    <h4>
        Rekapan Absensi</h4>
@stop
@section('currentMenuLink')
    {{ route('dashboard.rekapan') }}
@stop
@section('currentMenu')
    Rekapan Absen
@stop
@section('currentPage')
    {{ $user->nama }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Pilih Bulan</h6>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-5 col-sm-12">
                    <form action="{{ route('dashboard.rekapan.show', $user->id) }}" method="get">
                        <div class="input-group">
                            <div class="input-group-text" id="basic-addon1"><i class="bi bi-calendar-month"></i></div>
                            <input type="month" name="bulan" class="form-control" id="bulan"
                                placeholder="Recipient's username" aria-label="Recipient's username"
                                aria-describedby="button-addon2">
                            <button class="btn btn-outline-info" type="submit" id="button-addon2">
                                Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @if ($bulans !== null)
                <h2 class="mb-3">Rekapan Absensi Bulan {{ $bulanIni }} Tahun {{ $tahunIni }}</h2>
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover">
                        <thead>
                            <th>Tanggal</th>
                            <th>Jam Data Dibuat</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @forelse ($bulans as $bulan)
                                <tr>
                                    <td>{{ $bulan->created_at->format('d-m-Y') }}</td>
                                    <td> <span class="badge bg-primary">{{ $bulan->created_at->format('H:i:s') }}</span></td>
                                    <td>
                                        @if ($bulan->status_absensi === '2')
                                            <span class="badge bg-info">Cuti</span>
                                        @elseif($bulan->status_absensi === '3')
                                            <span class="badge bg-info">Sakit</span>
                                        @elseif($bulan->status_absensi === '4')
                                            <span class="badge bg-info">Izin</span>
                                            @elseif($bulan->status_absensi === '5')
                                            <span class="badge bg-success">Hari Libur</span>
                                            @elseif($bulan->status_absensi === '6')
                                            <span class="badge bg-secondary">Tidak Ada Jadwal</span>
                                        @elseif($bulan->status_absensi === '1')
                                            @if ($bulan->created_at->format('H:i:s') < '08:00:00')
                                                <span class="badge bg-success">Hadir</span>
                                            @else
                                                <span class="badge bg-warning">Terlambat</span>
                                            @endif
                                        @else
                                            <span class="badge bg-danger">Alfa</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <h6 class="mt-1">Belum Ada Data Absensi</h6>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @endif
        </div>
    </div>
@stop
