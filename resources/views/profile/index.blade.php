@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <style>
        .file {
            visibility: hidden;
            position: absolute;
        }
    </style>
    <h2>Profile</h2>
@endsection
@section('content')
    <div class="section full mt-2 mb-5">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('dashboard.profile.update') }}" id="form-profile" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="text" class="form-control" value="{{ Auth::user()->nama }}" name="nama"
                                    placeholder="Nama Lengkap" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="text" class="form-control" value="{{ Auth::user()->no_hp }}" name="no_hp"
                                    placeholder="No. HP" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="text" class="form-control" name="username"
                                    value="{{ Auth::user()->username }}" placeholder="Username" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}"
                                    placeholder="Email" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal">Ubah Kata Sandi</button>
                            </div>
                        </div>
                        <div class="form-group boxed">
                                <input type="file" name="photo" class="file image-input" accept="image/*">
                        <div class="input-group">
                            <input type="text" class="form-control image-filename" disabled placeholder="Ganti Photo Profile"
                                id="file">
                            <div class="input-group-append">
                                <button type="button" class="browse btn btn-primary">Klik Disini</button>
                            </div>
                        </div>
                        <div class="image-preview col-sm-12 col-md-6 mt-1">
        
                        </div>
                        </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <button type="button" onclick="formConfirmation('form-profile','Profile')"
                            class="btn btn-primary btn-block">
                            <ion-icon name="refresh-outline"></ion-icon>
                            Update
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Kata Sandi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-kata-sandi" action="{{ route('dashboard.profile.changePassword') }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <input type="password" class="form-control" id="recipient-name" name="kata_sandi_lama"
                                placeholder="Kata Sandi Lama">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="message-text" name="kata_sandi_baru"
                                placeholder="Kata Sandi Baru">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="formConfirmation('form-kata-sandi','Kata Sandi')"
                        class="btn btn-warning">Ganti</button>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        function formConfirmation(id, data) {
            let form = $(`#${id}`);
            Swal.fire({
                html: "Kamu Akan Memperbarui <h2>" + data + "</h2>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Perbarui!',
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
