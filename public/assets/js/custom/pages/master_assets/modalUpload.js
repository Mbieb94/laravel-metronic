$(function () {
    $("#kt_modal_1").on('show.bs.modal', function (e) {
        const data = $(e.relatedTarget);
        const modal = $(this);
        modal.find("#modal-body").load(data.data('remote'));
    });

    $("#kt_modal_import_excel").on('show.bs.modal', function (e) {
        const data = $(e.relatedTarget);
        const modal = $(this);
        modal.find("#modal-body").load(data.data('remote'));
    });

    $("#kt_modal_update_image").on('show.bs.modal', function (e) {
        const data = $(e.relatedTarget);
        const modal = $(this);
        modal.find("#modal-body").load(data.data('remote'));
    });

    $("#kt_modal_update_image").on('shown.bs.modal', function (e) {
        Select2Reference.init();
        $("select.select2-options").select2();
    });

    $(document).on('click', '.rm-img', function (e) {
        e.preventDefault();
        const imageUrl = $(this).data('path');
        const url = $(this).data('href');
        Swal.fire({
            text: 'Are you sure you want to delete this image?',
            imageUrl: imageUrl,
            imageWidth: 400,
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes Delete!",
            cancelButtonText: "No Cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": csrfToken,
                        "path": imageUrl
                    },
                    success: function (res) {
                        let { message } = res;
                        $('[data-bs-dismiss="modal"]').click();
                        toastr.info(message, 'Information !');
                    },
                    error: function (err) {
                        toastr.error('Image has not deleted!', 'Error !');
                    }
                });
            }
        });
    });
});