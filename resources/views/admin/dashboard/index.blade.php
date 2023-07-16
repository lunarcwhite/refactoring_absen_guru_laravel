@extends('layouts.dashboard_desktop.master')
@section('pageTitle')
    Dashboard
@stop
@section('content')
<div class="row">
    <div class="col-6 col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div
              class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
            >
              <div class="stats-icon purple mb-2">
                <i class="iconly-boldShow"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">
                Sudah Absen
              </h6>
              <h6 class="font-extrabold mb-0">{{$absenHariIni->count()}}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div
              class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
            >
              <div class="stats-icon blue mb-2">
                <i class="iconly-boldProfile"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Belum Absen</h6>
              <h6 class="font-extrabold mb-0">{{$belumAbsen}}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-4 col-md-6">
      <div class="card">
        <div class="card-body px-4 py-4-5">
          <div class="row">
            <div
              class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
            >
              <div class="stats-icon green mb-2">
                <i class="iconly-boldAdd-User"></i>
              </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
              <h6 class="text-muted font-semibold">Izin Perlu Konfirmasi</h6>
              <h6 class="font-extrabold mb-0">{{$izins->count()}}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
