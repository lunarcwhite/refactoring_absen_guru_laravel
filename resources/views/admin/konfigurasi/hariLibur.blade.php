@extends('layouts.dashboard_desktop.master')
@section('title')
Konfigurasi Hari Libur
@stop
@section('currentMenuLink')
    {{route('dashboard.setting.hariLibur')}}
@stop
@section('currentMenu')
    Konfigurasi Hari Libur
@stop
@section('currentPage')
Hari Libur
@endsection
@section('content')
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah
          </button>
        <hr/>
        <div class="table-responsive">
            <table class="table table-hover">
                    <thead>
                        <th>NO</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @forelse ($liburs as $no => $libur)
                            <tr>
                                <td>{{$no+1}}</td>
                                <td>{{$libur->tanggal}}</td>
                                <td>{{$libur->keterangan}}</td>
                                <td>
                                    <form action="{{route('dashboard.setting.hariLibur.delete',$libur->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger" onclick="formConfirmation('Hapus Hari Libur di Tanggal {{$libur->tanggal}}')">Hapus</button>    
                                    </form>    
                                </td>
                            </tr>
                        @empty
                            <h3>Belum ada data Hari Libur</h3>
                        @endforelse
                    </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('dashboard.setting.hariLibur.store')}}" method="post" id="form">
        <div class="modal-body">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar-month"></i></span>
                    <input id="tanggal" type="date" class="form-control" name="tanggal" placeholder="Addon to left" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="formConfirmation('Tetapkan tanggal '+document.getElementById('tanggal').value+' sebagai hari libur?')">Tambah</button>
                </div>
            </form>
      </div>
    </div>
  </div>
@stop