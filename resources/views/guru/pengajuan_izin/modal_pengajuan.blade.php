<div class="modal fade modalbox" id="modal_pengajuan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Pengajuan</h5>
                <a href="javascript:;" onclick="document.getElementById('formPengajuan').reset();"
                    data-dismiss="modal">Batal</a>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.izin.store') }}" method="post" id="formPengajuan"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group boxed">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal_pengajuan" id="tanggal">
                    </div>
                    <div id="lihat">
                        
                    </div>

                    <div class="form-group boxed">
                        <label for="tipe">Tipe Pengajuan</label>
                        <select name="tipe" id="tipe" class="form-control">
                            <option value="" class="form-control">--> Pilih Izin / Sakit / Cuti <-- </option>
                            <option value="Izin" class="form-control">Izin</option>
                            <option value="Sakit" class="form-control">Sakit</option>
                            <option value="Cuti" class="form-control">Cuti</option>
                        </select>
                    </div>
                    <div class="form-group boxed">
                        <input type="file" name="dokumen" class="file image-input" accept="image/*">
                        <div class="input-group" id="btnPilihGambar">
                            
                        </div>
                    </div>
                    <div class="image-preview col-12 mt-1">
                    
                    </div>
                    <div class="form-group boxed mb-3">
                        <label for="keterangan">Keterangan Pengajuan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" placeholder="keterangan" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer" id="modal-button">
                        <div class="form-button-group" id="buttonSubmit">
                            <button type="button" onclick="formConfirmation('Buat Pengajuan '+ $(`#tipe`).val()'?)"
                                class="btn btn-primary btn-block btn-lg">Buat</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
