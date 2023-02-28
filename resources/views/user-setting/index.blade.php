@extends('layouts.master')
@section('pageTitle')
    User Settings
@endsection
@section('contentTitle')
    Settings
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Data</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-bold-500">Username</td>
                    <td>{{ Auth::user()->username }}</td>
                    <td class="text-bold-500"><button type="button" data-bs-toggle="modal" class="btn btn-outline-info block"
                            onclick="('modal-update-account')"><i class="bi bi-pencil-square"></i></button></td>
                </tr>
                <tr>
                    <td class="text-bold-500">Email</td>
                    <td>{{ Auth::user()->email }}</td>
                    <td class="text-bold-500"><button type="button" data-bs-toggle="modal" class="btn btn-outline-info block"
                            onclick="('modal-update-account')"><i class="bi bi-pencil-square"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="text-bold-500">Password</td>
                    <td>{{ Auth::user()->password }}</td>
                    <td class="text-bold-500"><button type="button" data-bs-toggle="modal" class="btn btn-outline-info block"
                            onclick="('modal-update-account')"><i class="bi bi-pencil-square"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @include('user-setting.modal-update-account')
@stop
@push('js')
    <script>
        function updateAccount(id) {
            const myModalAlternative = new bootstrap.Modal(`#${id}`, show)
        }
    </script>
@endpush