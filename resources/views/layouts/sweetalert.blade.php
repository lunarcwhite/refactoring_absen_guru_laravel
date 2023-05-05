<link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}" />
<script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script>
    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type') }}";
        switch (type) {
            case 'success':
                Toastify({
                    text: "{{ Session::get('message') }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast()
              break;
            case 'error':
                Toastify({
                    text: "{{ Session::get('message') }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#c91a1a",
                }).showToast()
              break;
            default:
            Swal.fire(
                'Gagal',
                "{{ Session::get('message') }}",
                'error'
            )
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
