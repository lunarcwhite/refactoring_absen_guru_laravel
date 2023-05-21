@extends('layouts.dashboardAdmin')
@section('title')
    <h4>Konfigurasi Absen</h4>
@stop
@section('currentMenuLink')
    {{route('dashboard.setting.absen')}}
@stop
@section('currentMenu')
    Konfigurasi Jam dan Hari Absensi
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
                    <th>Username</th>
                    <TH>Aksi</TH>
                </thead>
                <tbody>
                    @foreach ($users as $no => $user)
                        <tr>
                            <td>{{$no+1}}</td>
                            <td>{{$user->username}}</td>
                            <td><a href="{{route('dashboard.setting.absen.setting',$user->id)}}" class="badge bg-info">Atur</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop