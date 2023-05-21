@extends('layouts.dashboardAdmin')
@section('title')
    <h4>Pengajuan Izin</h4>
@stop
@section('currentMenuLink')
    {{route('dashboard.pengajuan.pending')}}
@stop
@section('currentMenu')
    Pengajuan Izin
@stop
@section('currentPage')
Daftar Pengajuan
@endsection
@section('content')
<div class="row">
    <div class="col"><div class="table-responsive">
        <table class="table table-hover" id="myTable">
            <thead>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pengajuan</th>
                <th>Yang Mengajukan</th>
                <TH>Aksi</TH>
            </thead>
            <tbody>
                @foreach ($izins as $no => $izin)
                    <tr>
                        <td>{{$no+1}}</td>
                        <td>{{$izin->tanggal_untuk_pengajuan}}</td>
                        <td>{{$izin->tipe}}</td>
                        <td>{{$izin->user->nama}}</td>
                        <td><button onclick="openModal('modal-lihat-pengajuan',{{$izin->id}})" type="button" class="badge bg-info">Lihat</button>
                            {{-- <a href="{{route('dashboard.rekapan.show',$user->id)}}" class="badge bg-success">Setujui</a>
                            <a href="{{route('dashboard.rekapan.show',$user->id)}}" class="badge bg-danger">Tolak</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div></div>
</div>
<div class="modal fade" id="modal-lihat-pengajuan" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Pengajuan</h5>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('dashboard.pengajuan.konfirmasi')}}" method="post" id="konfirmasi">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tipe">Tanggal Pengajuan</label>
                        <input type="date" disabled id="tanggal-pengajuan" name="tanggal_pengajuan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tipe">Yang Mengajukan</label>
                        <input type="text" disabled id="yang-mengajukan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tipe">Status Pengajuan</label>
                        <input type="text" disabled id="status-pengajuan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tipe">Tipe Pengajuan</label>
                        <input type="text" disabled id="tipe-pengajuan" class="form-control">
                        <input type="hidden" id="id_pengajuan" name="id_pengajuan">
                    </div>
                    <input type="hidden" id="konfirmasi-pengajuan" name="konfirmasi_pengajuan">
                    <div class="form-group">
                        <label for="dokumen-pengajuan">Dokumen Pengajuan</label>
                        <div id="dokumen-pengajuan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan-pengajuan">Keterangan</label>
                        <textarea disabled id="keterangan-pengajuan" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer" id="modal-button">
                    <button type="button" onclick="konfirmasi('0')" class="btn btn-danger" >Tolak</button>
                    <button type="button" onclick="konfirmasi('1')" class="btn btn-success" >Setujui</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        function openModal(id, data) {
            $(`#${id}`).modal('show');
            if (data !== null) {
                $("#dokumen-pengajuan").empty();
                $.ajax({
                    type: 'get',
                    url: "/dashboard/presensi/izin/show/" + data,
                    dataType: 'json',
                    success: function(result) {
                        $("#tanggal-pengajuan").val(result.tanggal_untuk_pengajuan);
                        $("#id_pengajuan").val(result.id);
                        $("#yang-mengajukan").val(result.user['nama']);
                        if (result.status_approval === '2') {
                            $("#status-pengajuan").val('Menunggu Persetujuan');
                        } else if (result.status_approval === '1') {
                            $("#status-pengajuan").val('Disetujui');
                        } else {
                            $("#status-pengajuan").val('Ditolak');
                        }
                        $("#tipe-pengajuan").val(result.tipe);
                        $("#keterangan-pengajuan").val(result.keterangan);
                        $("#dokumen-pengajuan").append(
                            `<img src="{{ asset('storage/pengajuan/${result.tipe}/${result.tanggal_untuk_pengajuan}/${result.dokumen}') }}" class="img-fluid" width="100%"/>`
                            )
                    }
                });
            }
        }
        function konfirmasi(id) {
            let form = event.target.form;
            if ( id == 0){
                Swal.fire({
                    title: "Tolak Pengajuan?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#konfirmasi-pengajuan").val("tolak");
                        form.submit();
                    }
                })

            }
            else if(id == 1){
                Swal.fire({
                        title: "Setujui Pengajuan?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Setujui!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#konfirmasi-pengajuan").val("setuju");
                            form.submit();
                        }
                    })
            }
        };
    </script>
@endpush