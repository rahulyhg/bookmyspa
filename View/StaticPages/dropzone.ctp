<?php
echo $this->Html->script('frontend/jquery-1.11.1');
echo $this->Html->script('dropzone');
?>
<div id="photoContainer">

        <form action="/inspections/uploadphotos" method="post" 
        enctype="multipart/form-data" class="dropzone dz-clickable dropzone-previews" id="dropzone-form">

        </form>
           <button type="submit" id="dz" name="dz" value="Submit " /> Submit Photos</button>
    </div>
<script>
    $(document).ready(function() {

   Dropzone.options.dropzoneForm = {
            // The camelized version of the ID of the form element

            paramName: "files",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            previewsContainer: ".dropzone-previews",
            clickable: true,
            dictDefaultMessage: 'Add files to upload by clicking or droppng them here.',
            addRemoveLinks: true,
            acceptedFiles: '.jpg,.pdf,.png,.bmp',
            dictInvalidFileType: 'This file type is not supported.',

            // The setting up of the dropzone
            init: function () {
                var myDropzone = this;

                $("button[type=submit]").bind("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    // If the user has selected at least one file, AJAX them over.
                    if (myDropzone.files.length !== 0) {
                        myDropzone.processQueue();
                    // Else just submit the form and move on.
                    } else {
                        $('#dropzone-form').submit();
                    }
                });

                this.on("successmultiple", function (files, response) {
                    // After successfully sending the files, submit the form and move on.
                    $('#dropzone-form').submit();
                });
            }
        }
   });
</script

