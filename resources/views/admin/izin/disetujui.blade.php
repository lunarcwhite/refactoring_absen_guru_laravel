@extends('layouts.dashboard_desktop.master')
@section('title')
    Pengajuan Izin
@stop
@section('currentMenuLink')
    {{ route('dashboard.pengajuan.pending') }}
@stop
@section('currentMenu')
    Pengajuan Izin
@stop
@section('currentPage')
    Disetujui
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pengajuan</th>
                        <th>Yang Mengajukan</th>
                        <th>Status</th>
                        <TH>Aksi</TH>
                    </thead>
                    <tbody>
                        @foreach ($disetujuis as $no => $disetujui)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $disetujui->tanggal_untuk_pengajuan }}</td>
                                <td>{{ $disetujui->tipe }}</td>
                                <td>Nama Guru</td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                <td><button onclick="openModal('modal-lihat-pengajuan',{{ $disetujui->id }})" type="button"
                                        class="badge bg-info">Lihat</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-lihat-pengajuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Pengajuan</h5>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dashboard.pengajuan.konfirmasi') }}" method="post" id="konfirmasi">
                    @csrf
                    @method('patch')
                    @include('admin.izin.modal_body')
                    <div class="modal-footer" id="modal-button">
                        <button type="button" onclick="konfirmasi('0')" class="btn btn-danger">Tolak Setujui</button>
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
                    url: "/dashboard/pengajuan/show/" + data,
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
            if (id == 0) {
                $("#konfirmasi-pengajuan").val("tolak");
                formConfirmation('Batalkan Setujui?')
            } else if (id == 1) {
                $("#konfirmasi-pengajuan").val("setuju");
                formConfirmation('Setujui Pengajuan?')
            }
        };
    </script>
@endpush
