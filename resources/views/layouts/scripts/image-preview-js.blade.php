<script>
            function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();
                };

                reader.readAsDataURL(input.files[0]);

            }
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
