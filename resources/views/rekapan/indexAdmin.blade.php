@extends('layouts.dashboardAdmin')
@section('title')
    <h4>Rekapan Absensi</h4>
@stop
@section('currentMenuLink')
    {{route('dashboard.rekapan')}}
@stop
@section('currentMenu')
    Rekapan Absen
@stop
@section('currentPage')
Daftar Guru
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h6 class="card-title">About Vertical Navbar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="myTable">
                <thead>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <TH>Aksi</TH>
                </thead>
                <tbody>
                    @foreach ($users as $no => $user)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->no_hp}}</td>
                            <td><a href="{{route('dashboard.rekapan.show',$user->id)}}" class="badge bg-info">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop