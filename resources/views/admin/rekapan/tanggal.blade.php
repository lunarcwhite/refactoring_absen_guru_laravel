@extends('layouts.dashboard_desktop.master')
@section('title')
    <h4>
        Rekapan Absensi</h4>
@stop
@section('currentMenuLink')
    {{ route('dashboard.rekapan.tanggal') }}
@stop
@section('currentMenu')
    Rekapan Absen
@stop
@section('currentPage')
    Pertanggal
@endsection
@section('content')
<div class="row mb-5">
    <div class="col-md-5 col-sm-12">
        <form action="{{ route('dashboard.rekapan.tanggal') }}" method="get">
            <div class="input-group">
                <div class="input-group-text" id="basic-addon1"><i class="bi bi-calendar-month"></i></div>
                <input type="date" name="tanggal" class="form-control" id="bulan"
                    placeholder="Recipient's username" aria-label="Recipient's username"
                    aria-describedby="button-addon2">
                <button class="btn btn-outline-info" type="submit" id="button-addon2">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col">
        @if ($absens !== null)
    <h2 class="mb-3">Rekapan Absensi Tanggal {{ $tglIni }} Bulan {{ $bulanIni }} Tahun
        {{ $tahunIni }}</h2>
    <div class="table-responsive">
        <table id="myTable" class="table table-hover">
            <thead>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Status</th>
            </thead>
            <tbody>
                @forelse ($absens as $no => $absen)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td>{{$absen->user->nama}}</span></td>
                        <td>
                            @if ($absen->status_absensi === '2')
                                <span class="badge bg-info">Cuti</span>
                            @elseif($absen->status_absensi === '3')
                                <span class="badge bg-info">Sakit</span>
                            @elseif($absen->status_absensi === '4')
                                <span class="badge bg-info">Izin</span>
                            @elseif($absen->status_absensi === '5')
                                <span class="badge bg-success">Hari Libur</span>
                            @elseif($absen->status_absensi === '6')
                                <span class="badge bg-secondary">Tidak Ada Jadwal</span>
                            @elseif($absen->status_absensi === '7')
                                <span class="badge badge-secondary">Pengajuan Izin Ditolak</span>
                            @elseif($absen->status_absensi === '1')
                                @if ($absen->created_at->format('H:i:s') < '08:00:00')
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
