@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h2>Data Izin / Sakit</h2>
@endsection
@section('content')
    <div class="section full mt-2">
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
                                        <td>{{ $izin->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $izin->tipe }}</td>
                                        @if ($izin->status_approval === '2')
                                            <td>
                                                <p class="text-warning">Menunggu Persetujuan</p>
                                            </td>
                                        @elseif($izin->status_approval === '1')
                                            <td>
                                                <p class="text-success">Disetujui</p>
                                            </td>
                                        @else
                                            <td>
                                                <p class="text-danger">Ditolak</p>
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
                    <div class="fab-button bottom-right" style="margin-bottom: 95px">
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
                            <label for="tipe">Pilih Tipe Pengajuan</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="" class="form-control">--> Pilih Izin / Sakit <-- </option>
                                <option value="izin" class="form-control">Izin</option>
                                <option value="sakit" class="form-control">Sakit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dokumen">Unggah Dokumen Pendukung</label>
                            <input type="file" class="form-control-file" name="dokumen" id="dokumen">
                            <p class="text-small">*dokumen dengan format gambar</p>
                            <div id="imagewrapper">
                                <img id="showimage" preload="none" autoplay="autoplay" src="#" width="80%"
                                    height="auto">
                                <!--there would be a videoposter attribute, but that causes the issue on iOS that the video has no preview when it's done with loading... poster="https://i.imgur.com/JjqzFvI.png" -->
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" placeholder="keterangan" class="form-control"></textarea>
                        </div>
                    </form>
                </div>
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
                        <input type="text" disabled id="tanggal-pengajuan" class="form-control">
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
                            <label for="dokumen">Dokumen Pengajuan</label>
                            <div id="dokumen-pengajuan">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea disabled name="keterangan" id="keterangan-pengajuan" cols="30" rows="5" class="form-control"></textarea>
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
                        let date = new Date(result.created_at);
                        let tanggal = JSON.stringify(date.getDate()).length === 1 ? '0' + date.getDate() : date.getDate();
                        let bulan = JSON.stringify(date.getMonth()).length === 1 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1);
                        $("#tanggal-pengajuan").val(tanggal+'-'+bulan +'-'+date.getFullYear());
                        if (result.status_approval === '2') {
                            $("#status-pengajuan").val('Menunggu Persetujuan');
                        } else if(result.status_approval === '1'){
                            $("#status-pengajuan").val('Disetujui');
                        }else{
                            $("#status-pengajuan").val('Ditolak');
                        }
                        $("#tipe-pengajuan").val(result.tipe);
                        $("#keterangan-pengajuan").val(result.keterangan);
                        $("#dokumen-pengajuan").append(`<img src="{{ asset('storage/pengajuan/${result.tipe}/${date.getFullYear()}-${bulan}-${tanggal}/${result.dokumen}')}}" class="img-fluid" width="100%"/>`)
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
                    $('#showimage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#dokumen").change(function() {
            readURL(this);
        });

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
