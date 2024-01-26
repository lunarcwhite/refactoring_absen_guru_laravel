@extends('layouts.dashboard_desktop.master')
@section('title')
    <h4>Riwayat Absensi {{ $user->nama }}</h4>
@stop
@section('currentMenuLink')
    {{ route('dashboard.rekapan.guru', $user->id) }}
@stop
@section('currentMenu')
    Riwayat Absen
@stop
@section('currentPage')
    {{ $user->nama }}
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="button-group">
                <button type="button" onclick="clearInput('formAbsen','Tambah Absen {{$user->nama}}',`dashboard/rekapan/tambah`, true)" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalFormAbsen">
                    Tambah
                  </button>
            </div>
            <hr/>
            <div class="table-responsive">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <th>Tanggal</th>
                        <th>Jam Absen</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @forelse ($absens as $absen)
                            <tr>
                                <td>{{ $absen->created_at->format('d-m-Y') }}</td>
                                <td> <span class="badge bg-primary">{{ $absen->created_at->format('H:i:s') }}</span>
                                </td>
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
                                <td>
                                    <form action="{{route('dashboard.rekapan.deleteAbsen', $absen->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="formConfirmation('Hapus absen {{$user->nama}} tanggal {{$absen->tanggal_absensi}}')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <h6 class="mt-1">Belum Ada Data Absensi</h6>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.rekapan.modalFormTambahAbsen')
@stop
