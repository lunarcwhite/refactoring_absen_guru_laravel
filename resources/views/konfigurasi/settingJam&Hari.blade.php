@extends('layouts.dashboardAdmin')
@section('title')
    <h4>Konfigurasi Absen {{ $user->nama }}</h4>
    <a href="{{ url()->previous() }}" class="btn btn-primary mt-2">Kembali</a>
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
                        <button class="me-1 btn btn-primary" onclick="konfirmasi()" type="button">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
           
        </div>
    </div>
@stop
@push('js')
    <script>
        // function enable(status, jam) {
        //     if ($(`#${status}`).val() == 1) {
        //         $(`#${jam}`).prop("disabled", false).prop("required", true);
        //     } else {
        //         $(`#${jam}`).prop("disabled", true).prop("required", false);;
        //     }
        // }

        function konfirmasi() {
            let form = $(`#form`);
            Swal.fire({
                title: "Simpan Settingan",
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
