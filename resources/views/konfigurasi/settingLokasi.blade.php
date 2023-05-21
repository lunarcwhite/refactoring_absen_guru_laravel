@extends('layouts.dashboardAdmin')
@section('title')
    <h4>Konfigurasi Lokasi Absen</h4>
    <a href="{{url()->previous()}}" class="btn btn-primary mt-2">Kembali</a>
@stop
@section('currentMenuLink')
    {{route('dashboard.setting.lokasi')}}
@stop
@section('currentMenu')
    Konfigurasi Lokasi Absen
@stop
@section('currentPage')
Lokasi Absen
@endsection
@section('content')
<div class="row mt-3">
    <div class="col-md-6 col-sm-12">
        <form action="{{route('dashboard.setting.lokasi.update')}}" method="post" id="form">
            @csrf
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Status</label>
                <select class="form-select" name="status" id="inputGroupSelect01">
                  @if ($lokasi->status == 1)
                  <option value="1" selected>Aktif</option>
                  <option value="0">Tidak Aktif</option>
                @else
                <option value="1">Aktif</option>
                  <option value="0" selected>Tidak Aktif</option>
                  @endif
                </select>
              </div>
            <div class="form-group">
                <span class="input-group-text" id="basic-addon1">Titik Koordinat (Latitude Longitude)</span><br>
                <input id="lokasi" type="text" value="{{$lokasi->lokasi}}" class="form-control" name="lokasi" placeholder="Addon to left" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Radius Absen (meter)</span>
                <input id="radius" type="text" value="{{$lokasi->radius}}" class="form-control" name="radius" placeholder="Addon to left" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="me-1 btn btn-primary" onclick="konfirmasi()" type="button">Simpan</button>
              </div>
        </form>
    </div>
</div>
@stop
@push('js')
    <script>
        function konfirmasi()
        {
            let form = $(`#form`);
            Swal.fire({
                    title: `Simpan Konfigurasi?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
        }
    </script>
@endpush