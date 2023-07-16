<div class="modal fade text-left" id="modalImportGuru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="labelModal">
                    Import Guru
                </h4>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            <a href="{{url('template_import/template_import_guru.xlsx')}}" class="btn btn-info">Download Template</a>
            <hr/>
                <form action="{{ route('dashboard.kelolaGuru.import') }}" method="post" id="formImportGuru" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mt-1">
                        <label for="email">Pilih File Dari File Excel</label>
                        <input id="import_guru" type="file" name="import_guru" placeholder="Nama Akun"
                            class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="formConfirmation('Import Data?')"
                    class="btn btn-primary ms-1">
                    Import
                </button>
            </form>
            </div>
        </div>
    </div>
</div>
