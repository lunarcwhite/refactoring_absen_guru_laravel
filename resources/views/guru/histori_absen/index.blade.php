@extends('layouts.dashboard_mobile.master')
@section('pageTitle')
    Histori Presensi
@stop
@section('content')
    <div class="section mt-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="{{ route('dashboard.histori.index') }}" method="get">
                            <div class="form-group boxed mb-3">
                                <div class="input-wrapper">
                                    <label for="bulan">Inputkan Bulan dan Tahunnya Pada Inputan Dibawah</label>
                                    <br />
                                    <input type="month" class="form-control" name="bulan" id="bulan"
                                        placeholder="Password" autocomplete="off">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="search-circle-outline"></ion-icon>
                                </div>Tampilkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="card">
            @if ($bulans)
            <div class="card-header">
                <h2>Rekapan Absensi Bulan {{ $bulanIni }} Tahun {{ $tahunIni }}</h2>
            </div>
            <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped display nowrap">
                            <thead>
                                <th>Tanggal Absen</th>
                                <th>Status Absen</th>
                                <th>Jam Absen Masuk</th>
                            </thead>
                            <tbody>
                                @forelse ($bulans as $no => $item)
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
                @endif
        </div>
    </div>
@stop
@push('js')
@endpush
