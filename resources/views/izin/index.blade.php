@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <style>
        .file {
            visibility: hidden;
            position: absolute;
        }
    </style>
    <h2>Data Izin / Sakit</h2>
@endsection
@section('content')
    <div class="section full mt-2  mb-5">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
                                            <button type="button" class="btn-sm btn-outline-info"
                                                onclick="openModal('modal-lihat-pengajuan',{{ $izin->id }})">
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
                        <div class="fab-button bottom-right" style="margin-bottom: 75px">
                            <button class="fab" onclick="openModal('modal-pengajuan',null)">
                                <ion-icon name="add-outline"></ion-icon>
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-pengajuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.presensi.izin.store') }}" method="post" id="form-formulir"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal_pengajuan" id="tanggal">
                        </div>
                        <div class="form-group">
                            <label for="tipe">Pilih Tipe Pengajuan</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="" class="form-control">--> Pilih Izin / Sakit / Cuti <-- </option>
                                <option value="izin" class="form-control">Izin</option>
                                <option value="sakit" class="form-control">Sakit</option>
                                <option value="cuti" class="form-control">Cuti</option>
                            </select>
                        </div>
                        <div class="form-group boxed">
                            <input type="file" name="dokumen" class="file image-input" accept="image/*">
                            <div class="input-group">
                                <input type="text" class="form-control image-filename" disabled
                                    placeholder="Unggah Dokumen" id="file">
                                <div class="input-group-append">
                                    <button type="button" class="browse btn btn-primary">Klik Disini</button>
                                </div>
                            </div>
                            <div class="image-preview col-12 mt-1">

                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" placeholder="keterangan" class="form-control"></textarea>
                        </div>
                </div>
                </form>
                <div class="modal-footer" id="modal-button">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('modal-pengajuan')">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="buatFormulir()">Buat</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-lihat-pengajuan" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tipe">Tanggal Pengajuan</label>
                        <input type="date" disabled id="tanggal-pengajuan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tipe">Status Pengajuan</label>
                        <input type="text" disabled id="status-pengajuan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tipe">Tipe Pengajuan</label>
                        <input type="text" disabled id="tipe-pengajuan" class="form-control">
                    </div>
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
                    <button type="button" class="btn btn-danger"
                        onclick="closeModal('modal-lihat-pengajuan')">Tutup</button>
                </div>
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
                        // let date = new Date(result.created_at);
                        // let tanggal = JSON.stringify(date.getDate()).length === 1 ? '0' + date.getDate() : date.getDate();
                        // let bulan = JSON.stringify(date.getMonth()).length === 1 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1);
                        $("#tanggal-pengajuan").val(result.tanggal_untuk_pengajuan);
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

        function closeModal(id) {
            $(`#${id}`).modal('hide');
        }

        function buatFormulir() {
            let form = $("#form-formulir");
            let tipe = $("#tipe").val();
            Swal.fire({
                html: `Kamu Akan Membuat <br/> Formulir Pengajuan <h2> ${tipe} </h2>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Buat!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
        $(document).on("click", ".browse", function() {
            $('.image-preview').empty();
            var file = $(this).parents().find(".file");
            file.trigger("click");
        });
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $("#file").val(fileName);

            var reader = new FileReader();
            reader.onload = function(e) {
                // get loaded data and render thumbnail.
                $('.image-preview').append(
                    `<button type="button" class="close bg-danger" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button><img src="https://placehold.it/80x80" id="preview" class="img-thumbnail">`
                );
                document.getElementById("preview").src = e.target.result;
            };
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        });
        $(document).on("click", ".close", function() {
            $('.image-preview').empty();
            $("#file").val("");
            $(".file").val("");
        });
    </script>
@endpush
