<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    
    @if (Session::has('success'))
        Toastify({
            text: `{{ Session::get('success') }}`,
            duration: 2000,
            gravity: "top",
            position: "right",
            style: {
                background: "#4fbe87",
            }
        }).showToast()
    @endif

    @if ($errors->any())
        @php
            $message = '';
            foreach ($errors->all() as $error) {
                $message .= "<li> $error </li>";
            }
        @endphp
        Swal.fire({
            text: 'Error',
            html: `{!! $message !!}`,
            icon: `error`,
        })
    @endif

    function formConfirmation(message) {
        var form = event.target.form;
        Swal.fire({
            html: `<h3>${message}</h3>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    function formConfirmationId(idForm, message) {
        var form = $(`${idForm}`);
        console.log();
        Swal.fire({
            html: `<h3>${message}</h3>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }
</script>
