@extends('layouts.dashboard_mobile.master')
@section('pageTitle')
    Pengajuan Izin
@stop
@section('pageRightButton')
    <a href="" onclick="event.preventDefault();$('#lihat').empty();buat()" data-toggle="modal"
        data-target="#modal_pengajuan" class="headerButton">
        <span class="btn btn-primary hapus">Buat</span>
    </a>
@endsection
@section('content')
    <div class="section full mt-2  mb-5">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped display nowrap">
                            <thead>
                                <th>Tanggal</th>
                                <th>Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @forelse ($izins as $izin)
                                    <tr>
                                        <td>{{ $izin->tanggal_untuk_pengajuan }}</td>
                                        <td>{{ $izin->tipe }}</td>
                                        @if ($izin->status_approval === '2')
                                            <td>
                                                <p class="badge badge-warning">Pending</p>
                                            </td>
                                        @elseif($izin->status_approval === '1')
                                            <td>
                                                <p class="badge badge-success">Disetujui</p>
                                            </td>
                                        @else
                                            <td>
                                                <p class="badge badge-danger">Ditolak</p>
                                            </td>
                                        @endif
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#modal_pengajuan"
                                                class="btn-sm btn-outline-info hapus" onclick="lihat({{ $izin->id }})">
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <h1>Belum Ada Pengajuan</h1>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('guru.pengajuan_izin.modal_pengajuan')

@stop
@push('js')
    <script>
        $(document).ready(function() {
            $('.hapus').click(function() {
                $('#lihat').empty();
                $('#buttonSubmit').empty();
                $(".kapilih").removeAttr('selected');
                $('#tipe').prop('disabled',false);
                $("#btnPilihGambar").empty();
            });
        });

        function buat() {
            $('#buttonSubmit').append(
                `<button type="button" onclick="formConfirmation('Buat Pengajuan '+ $('#tipe').val())"
                                class="btn btn-primary btn-block btn-lg">Buat</button>`
            );
            $("#tanggal").prop("disabled", false);
            $("#keterangan").prop("disabled", false);
            $("#btnPilihGambar").append(
                `<input type="text" class="form-control image-filename" disabled
                                placeholder="Unggah Dokumen" id="file">
                            <div class="input-group-append" >
                                <button type="button" class="browse btn btn-primary">Klik Disini</button>
                            </div>`
            );
        }

        function lihat(id_data) {
            $.ajax({
                type: 'get',
                url: "/dashboard/izin/show/" + id_data,
                dataType: 'json',
                success: function(result) {
                    $("#tanggal").val(result.tanggal_untuk_pengajuan).prop("disabled", "disabled")
                    if (result.status_approval === '2') {
                        $("#lihat").append(
                            `<div class="form-group">
                                <label for="tipe">Status Pengajuan</label>
                            <input type="text" value="Menunggu Persetujuan" disabled id="status-pengajuan" class="form-control"></div>`
                        );
                    } else if (result.status_approval === '1') {
                        $("#lihat").append(
                            `<div class="form-group">
                                <label for="tipe">Status Pengajuan</label>
                            <input type="text" value="Disetujui" disabled id="status-pengajuan" class="form-control"></div>`
                        );
                    } else {
                        $("#lihat").append(
                            `<div class="form-group">
                                <label for="tipe">Status Pengajuan</label>
                            <input type="text" value="Ditolak" disabled id="status-pengajuan" class="form-control"></div>`
                        );
                    }
                    $(`#tipe option[value="${result.tipe}"]`).attr("selected", "selected").attr('class', 'kapilih');
                    $(`#tipe`).prop('disabled',true);
                    $("#keterangan").val(result.keterangan).prop("disabled", "disabled");
                    $("#lihat").append(
                        `<img src="{{ asset('storage/pengajuan/${result.tipe}/${result.tanggal_untuk_pengajuan}/${result.dokumen}') }}" class="img-fluid" width="100%"/>`
                    )
                }
            });
        }
    </script>
@endpush
