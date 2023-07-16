@extends('layouts.dashboard_desktop.master')
@section('title')
    <h4>Absensi Hari Ini</h4>
@stop
@section('currentMenuLink')
    {{route('dashboard.rekapan.hariIni')}}
@stop
@section('currentMenu')
    {{date('d-m-Y')}}
@stop
@section('currentPage')
Absen Hari Ini
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover" id="myTable">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Status Absensi</th>
                    <th>Jam Data Dibuat</th>
                </thead>
                <tbody>
                    @foreach ($absens as $no => $absen)
                        <tr>
                            <td>{{$no+1}}</td>
                            <td>{{$absen->nama}}</td>
                            <td><span class="badge bg-primary">{{$absen->status}}</span></td>
                            <td>{{$absen->jam}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop