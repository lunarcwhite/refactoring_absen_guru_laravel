@extends('layouts.menuHalamanUser')
@section('pageTitle')
<style>
    .file-upload {
        background-color: #ffffff;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 200;
    }

    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
    }
    .file-upload-image {
        max-height: 500px;
        max-width: 100%;
        margin: auto;
        padding: 10px;
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
                    @if ($absen < 1 && $izinHariIni !== 1)
                    <div class="fab-button bottom-right" style="margin-bottom: 75px">
                        <button class="fab" onclick="openModal('modal-pengajuan',null)">
                            <ion-icon name="add-outline"></ion-icon>
                        </button>
                    </div>
                    @endif
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
                        <div class="file-upload">
                            <button class="file-upload-btn" type="button"
                                onclick="$('.file-upload-input').trigger( 'click' )">Unggah Dokumen Pendukung</button>
                            <input class="file-upload-input" name="dokumen" type='file' onchange="readURL(this);"
                                accept="image/*" />
                            <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
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
    <div class="modal fade" id="modal-lihat-pengajuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" onclick="closeModal('modal-lihat-pengajuan')">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        function openModal(id, data) {
            $(`#${id}`).modal('show');
            if(data !== null){
                $("#dokumen-pengajuan").empty();
                $.ajax({
                    type: 'get',
                    url: "/dashboard/presensi/izin/show/" + data,
                    dataType: 'json',
                    success: function(result){
                        // let date = new Date(result.created_at);
                        // let tanggal = JSON.stringify(date.getDate()).length === 1 ? '0' + date.getDate() : date.getDate();
                        // let bulan = JSON.stringify(date.getMonth()).length === 1 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1);
                        $("#tanggal-pengajuan").val(result.tanggal_untuk_pengajuan);
                        if (result.status_approval === '2') {
                            $("#status-pengajuan").val('Menunggu Persetujuan');
                        } else if(result.status_approval === '1'){
                            $("#status-pengajuan").val('Disetujui');
                        }else{
                            $("#status-pengajuan").val('Ditolak');
                        }
                        $("#tipe-pengajuan").val(result.tipe);
                        $("#keterangan-pengajuan").val(result.keterangan);
                        $("#dokumen-pengajuan").append(`<img src="{{ asset('storage/pengajuan/${result.tipe}/${result.tanggal_untuk_pengajuan}/${result.dokumen}')}}" class="img-fluid" width="100%"/>`)
                    }
                });
            }
        }
        function closeModal(id) {
            $(`#${id}`).modal('hide');
        }

        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            }
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
    </script>
@endpush
