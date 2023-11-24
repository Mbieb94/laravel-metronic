$(function () {
    $(".app-page-loader-bo").fadeOut('slow', function () {
        $(this).removeClass("d-block");
    });

    $(".app-page-loader-web").slideUp('slow', function () {
        $(this).removeClass("d-block");
    });

    $(document).on("click", ".btn-indicator", function () {
        const btn = $(this);
        btn.attr('data-kt-indicator', 'on');
        btn.attr('disabled', true);

        btn.closest("form").submit();
    });

    $(".btn-submit").on("click", function () {
        const btn = $(this);
        $('input[name=xsubmit]').val(btn.data("xsubmit"));
        $('#formValidate').submit();
        btn.attr('data-kt-indicator', 'on');
        btn.attr('disabled', true);
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toastr-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    if ($('body').attr('notification_success')) 
        toastr.success($('body').attr('notification_message'));

    if ($('body').attr('notification_warning'))
        toastr.warning($('body').attr('notification_message'), 'Warning!');

    if ($('body').attr('notification_info'))
        toastr.info($('body').attr('notification_message'), 'Info!');

    if ($('body').attr('notification_error')) {
        let errorList = JSON.parse($('body').attr('notification_data'));
        for (i = 0; i < errorList.length; i++) {
            toastr.error(errorList[i], "Opss Error !")
        }
    }

    // DELETE ROWS FROM DETAIL PAGE
    $(".delete-row").on("click", function (e) {
        e.preventDefault();
        const url = $(this).data('remote');
        console.log(url);
        const message = $(this).data('message');
        const tableName = $(this).data('tablename');
        Swal.fire({
            text: message,
            icon: "warning",
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
                    type: "POST",
                    headers: {
                        'Authorization': `Bearer ${personalToken}`
                    },
                    success: function (resp) {
                        Swal.fire({
                            text: "Rows successfully deleted !",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Yes",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function () {
                            window.location.href = `${hostUrl}/${tableName}`;
                        });
                    }
                });
            } else if (result.dismiss === 'cancel') {
                Swal.fire({
                    text: "Rows Not Deleted.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Yes",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                });
            }
        });
        console.log(123);
    });

    $("#btn-dismiss").on("click", function(e){
        $(this).closest('div.alert').slideUp('slow', function(){
            $(this).remove();
        });
    });

    $(document).on("click", ".copy", function(e){
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($(this).closest('span').find('.text-copy').text()).select();
        document.execCommand("copy");
        temp.remove();
        toastr.info('Text copied to clipboard!', 'Info!')
    });

    $("select.select2multiple").on("change", function(e){
        let select = $(this);
        let selected = $(select).find(":selected");

        let data = [];
        for (let index = 0; index < selected.length; index++) {
            data.push($(selected[index]).val());
        }

        $(select).closest('.select-multiple').find('input[type=hidden]').val(JSON.stringify(data));
    });
});
