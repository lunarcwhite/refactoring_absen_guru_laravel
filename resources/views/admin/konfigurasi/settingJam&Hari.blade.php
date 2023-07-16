@extends('layouts.dashboard_desktop.master')
@section('title')
Konfigurasi Absen {{ $user->nama }}
    
@stop
@section('currentMenuLink')
    {{ route('dashboard.setting.absen') }}
@stop
@section('currentMenu')
    Konfigurasi Jam dan Hari Absensi
@stop
@section('currentPage')
    {{ $user->nama }}
@endsection
@section('content')
    <div class="row mt-3">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url()->previous() }}" class="btn btn-primary mt-2">Kembali</a>
                </div>
                <div class="card-body">
                    @php
                    $hari = ['Sunday' => 'Minggu','Monday' => 'Senin','Tuesday' => 'Selasa','Wednesday' => 'Rabu ','Thursday' => 'Kamis','Friday' => 'Jumat','Saturday' => 'Sabtu'];
                @endphp
                <form action="{{ route('dashboard.setting.absen.update', $user->id) }}" method="post" id="form">
                    @csrf
                    @method('put')
                    @foreach ($settings as $index => $setting)
                    <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input type="hidden" name="id[]" value="{{$setting->id}}">
                            <select name="status[]" id="status_{{$setting->hari}}" class="form-control">
                                @if ($setting->status == 1)
                                <option value="1" selected>Aktif</option> 
                                <option value="0">Nonaktif</option>
                                @else
                                <option value="1">Aktif</option>
                                <option value="0" selected>Nonaktif</option>  
                                @endif
                            </select>
                            <span class="ms-2 mark"><strong>{{$hari[$setting->hari]}}</strong></span>
                            <input type="hidden" value="{{$setting->hari}}" name="hari[]">
                        </div>
                        <input type="text" class="form-control" name="jam[]" id="jam_{{$setting->hari}}"
                            value="{{$setting->jam}}" aria-label="Text input with checkbox" placeholder="Jam. Contoh 07:00:00">
                    </div>
                </div>
                    @endforeach
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="me-1 btn btn-primary" onclick="formConfirmation('Simpan Konfigurasi Absen {{$user->nama}}')" type="button">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
           
        </div>
    </div>
@stop
