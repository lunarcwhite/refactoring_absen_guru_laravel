<div class="modal fade" id="modalFormGuru" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelModal"></h5>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.kelolaGuru.store') }}" method="POST" id="formGuru">
                    @csrf
                    <div id="update">

                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama Guru</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">NUPTK</label>
                        <input type="text" class="form-control" id="nuptk" name="nuptk">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div id="password_akun">

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="formConfirmation('Simpan Data?')"
                    class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>