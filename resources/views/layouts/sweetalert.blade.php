<link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}" />
<script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    })

    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type') }}";

        switch (type) {
            case 'info':
                Toast.fire({
                    icon: 'info',
                    title: "{{ Session::get('message') }}"
                })
                break;
            case 'success':
                Toast.fire({
                    icon: 'success',
                    title: "{{ Session::get('message') }}"
                })
                break;
            case 'warning':
                Toast.fire({
                    icon: 'warning',
                    title: "{{ Session::get('message') }}"
                })
                break;
            case 'error':
                Swal.fire({
                    icon: 'error',
                    title: "Gagal",
                    html: "{{ Session::get('message') }}",
                })
                break;
            case 'dialog_error':
                Swal.fire({
                    icon: 'error',
                    title: "Oppssss",
                    text: "{{ Session::get('message') }}",
                    timer: 3000
                })
                break;
        }
    @endif
    @if ($errors->any())
        @php
            $message = '';
            foreach ($errors->all() as $error) {
                $message .= "<li> $error </li>";
            }
        @endphp
        Swal.fire({
            title: 'Error',
            html: "{!! $message !!}",
            icon: 'error',
        })
    @endif
</script>
