<div class="modal fade" id="modalFormAbsen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelModal"></h5>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.rekapan.tambahAbsen') }}" method="POST" id="formAbsen">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Tanggal Absensi</label>
                        <input type="date" class="form-control" id="tanggal_absensi" name="tanggal_absensi">
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$user->id}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status Absensi</label>
                        <select class="form-control" name="status_absensi" id="status_absensi">
                            <option value="">--Pilih Status Absen--</option>
                            <option value="1">Hadir</option>
                            <option value="3">Sakit</option>
                            <option value="4">Izin</option>
                            <option value="2">Cuti</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="formConfirmation('Tambah Data?')"
                    class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>