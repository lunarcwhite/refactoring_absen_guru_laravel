@extends('layouts.dashboard_desktop.master')
@section('title')
    <h4>Rekapan Absensi</h4>
@stop
@section('currentMenuLink')
    {{route('dashboard.rekapan.guru')}}
@stop
@section('currentMenu')
    Rekapan Absen
@stop
@section('currentPage')
Daftar Guru
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover" id="myTable">
                <thead>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <TH>Aksi</TH>
                </thead>
                <tbody>
                    @foreach ($users as $no => $user)
                        <tr>
                            <td>{{$no+1}}</td>
                            <td>{{$user->nama}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->no_hp}}</td>
                            <td><a href="{{route('dashboard.rekapan.show.guru',$user->id)}}" class="badge bg-info">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop