@extends('layouts.menuHalamanUser')
@section('pageTitle')
    <h2>Profile</h2>
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

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #222;
        }

        .file-upload-image {
            max-height: 500px;
            max-width: 100%;
            margin: auto;
            padding: 10px;
        }

        .remove-image {
            width: 100%;
            margin: 0;
            color: #fff;
            background: #cd4535;
            border: none;
            padding: 10px;
            border-radius: 4px;
            border-bottom: 4px solid #b02818;
            transition: all .2s ease;
            outline: none;
            text-transform: uppercase;
            font-weight: 200;
        }

        .remove-image:hover {
            background: #c13b2a;
            color: #ffffff;
            transition: all .2s ease;
            cursor: pointer;
        }

        .remove-image:active {
            border: 0;
            transition: all .2s ease;
        }
    </style>
@endsection
@section('content')
    <div class="section full mt-2 mb-5">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <div class="row">
                <div class="col">
                    <form action="{{ route('dashboard.profile.update') }}" id="form-profile" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="text" class="form-control" value="{{Auth::user()->nama}}" name="nama"
                                    placeholder="Nama Lengkap" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="text" class="form-control" value="{{Auth::user()->no_hp}}" name="no_hp"
                                    placeholder="No. HP" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="text" class="form-control" name="username" value="{{Auth::user()->username}}" placeholder="Username"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}" placeholder="Email"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Ubah Kata Sandi</button>
                            </div>
                        </div>
                        <div class="file-upload">
                            <button class="file-upload-btn" type="button"
                                onclick="$('.file-upload-input').trigger( 'click' )">Klik Disini Untuk Mengunggah Foto
                                Profile</button>
                            <input class="file-upload-input" name="photo" type='file' onchange="readURL(this);"
                                accept="image/*" />
                            <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image">Hapus <span
                                            class="image-title">Uploaded Image</span></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <button type="button" onclick="formConfirmation('form-profile','Profile')" class="btn btn-primary btn-block">
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
              <form id="form-kata-sandi" action="{{route('dashboard.profile.changePassword')}}" method="post">
                @csrf
                @method('patch')
                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                <div class="form-group">
                  <input type="password" class="form-control" id="recipient-name" name="kata_sandi_lama" placeholder="Kata Sandi Lama">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="message-text" name="kata_sandi_baru" placeholder="Kata Sandi Baru">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="button" onclick="formConfirmation('form-kata-sandi','Kata Sandi')" class="btn btn-warning">Ganti</button>
            </div>
          </div>
        </div>
      </div>
@stop
@push('js')
    <script>
        function formConfirmation(id,data)
        {
            let form = $(`#${id}`);
            Swal.fire({
                    html: "Kamu Akan Memperbarui <h2>"+data+"</h2>",
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

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function() {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function() {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>
@endpush
