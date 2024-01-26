@extends('layouts.dashboard_desktop.master')
@section('title')
@if ($ks)
<h4>Kepala Sekolah Saat Ini : {{ $ks->nama }} </h4>
@else    
<h4>Kepala Sekolah Saat Ini : Tidak ada </h4>

@endif
@stop
@section('currentMenuLink')
    {{ route('dashboard.rekapan.guru') }}
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
                        @if ($ks)
                        <tr>
                            <td></td>
                            <td>{{ $ks->nama }}</td>
                            <td>{{ $ks->email }}</td>
                            <td>{{ $ks->no_hp }}</td>
                            <td>
                                <form action="{{route('dashboard.setting.kepalaSekolahUpdate', $ks->id)}}" method="post">
                                    @method('patch')
                                    @csrf
                                    <input type="hidden" name="status" value="turun" readonly>
                                    <button type="button" onclick="formConfirmation('Turunkan {{$ks->nama}} dari jabatan kepala sekolah?')" class="btn btn-danger">Turunkan</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @foreach ($users as $no => $user)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_hp }}</td>
                                <td>
                                    <form action="{{route('dashboard.setting.kepalaSekolahUpdate', $user->id)}}" method="post">
                                        @method('patch')
                                        @csrf
                                        <input type="hidden" name="status" value="angkat" readonly>
                                        <button type="button" onclick="formConfirmation('Angkat {{$user->nama}} menjadi kepala sekolah?')" class="btn btn-success">Angkat</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
