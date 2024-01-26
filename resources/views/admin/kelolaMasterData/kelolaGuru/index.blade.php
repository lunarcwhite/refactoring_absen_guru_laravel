@extends('layouts.dashboard_desktop.master')
@section('title')
    Data Guru
@stop
@section('currentMenuLink')
    {{ route('dashboard.kelolaGuru.index') }}
@stop
@section('currentMenu')
    Data Guru
@stop
@section('currentPage')
    Daftar Guru
@endsection
@section('content')
    <div class="row">
        <div class="col">
            {{-- <div class="d-flex justify-content-between">
            <a href="{{url()->previous()}}" class="btn btn-primary">Kembali</a>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalBiaya">Tambah Biaya Untuk Jurusan</button>
        </div> --}}
            <div class="button-group">
                <button type="button" onclick="clearInput('formGuru','Tambah Guru',`dashboard/kelolaGuru`, true)"
                    class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalFormGuru">
                    Tambah
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportGuru">
                    Import
                </button>
            </div>
            <hr />
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <th>No</th>
                        <th>NUPTK</th>
                        <th>Nama Guru</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <TH>Aksi</TH>
                    </thead>
                    <tbody>
                        @foreach ($users as $no => $user)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $user->nuptk }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_hp }}</td>
                                <td>
                                    <form action="{{ route('dashboard.kelolaGuru.destroy', $user->id) }}" id=""
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-sm btn-warning"
                                            onclick="editGuru('{{ $user->id }}','#modalFormGuru')">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="formConfirmation('Hapus Data {{ $user->nama }}')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.kelolaMasterData.kelolaGuru.modalFormGuru')
    @include('admin.kelolaMasterData.kelolaGuru.modalImportGuru')
@stop
@push('js')
    <script>
        function editGuru(idData, idModal) {
            let password = $("#password_akun");
            password.empty();
            $.ajax({
                type: "get",
                url: `{{ url('dashboard/kelolaGuru/${idData}/edit') }}`,
                dataType: 'json',
                success: function(res) {
                    $("#nama").val(res.nama);
                    $("#username").val(res.username);
                    $("#email").val(res.email);
                    $("#no_hp").val(res.no_hp);
                    $("#nuptk").val(res.nuptk);
                    password.append(
                        `<div class="form-group mt-1">
                        <label for="email">Password: </label>
                        <input id="password" type="password" value="${res.password}" name="password" placeholder="Password"
                            class="form-control" />
                    </div>`
                    )
                    $(`#labelModal`).text('Edit Data Guru');
                    $(`#btn-submit`).text('Update');
                    $('#update').append(
                        `@method('put')`
                    );
                    document.getElementById('formGuru').action =
                        `{{ url('dashboard/kelolaGuru/${res.id}') }}`;
                    $(idModal).modal('show');
                }
            });
        }
    </script>
@endpush
