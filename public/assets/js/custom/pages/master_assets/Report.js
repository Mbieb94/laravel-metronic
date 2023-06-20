$(function() {
    $(document).on('change', '#cost-switcher', function (e) {
        const data = $(this).attr('checked');
        if(data) {
            $(this).removeAttr('checked');

            $('select[name="cost_centre!gte"]').val(null).trigger('change');
            $('select[name="cost_centre!lte"]').val(null).trigger('change');
            
            $("#cost-centre-range").show();
            $("#cost-centre-multiple").addClass('d-none');
        } else {
            $(this).attr('checked', true);
            $('select[data-model="cost_centres"]').val(null).trigger('change');
            $("#cost-centre-range").hide();
            $("#cost-centre-multiple").removeClass('d-none');
        }
    });

    $(document).on('change', '#plant-code-switcher', function (e) {
        const data = $(this).attr('checked');
        if(data) {
            $(this).removeAttr('checked');

            $('select[name="plant_code!gte"]').val(null).trigger('change');
            $('select[name="plant_code!lte"]').val(null).trigger('change');

            $("#plant-code-range").show();
            $("#plant-code-multiple").addClass('d-none');;
        } else {
            $("#plant-code-range").hide();
            $('select[data-model="plant_codes"]').val(null).trigger('change');
            $("#plant-code-multiple").removeClass('d-none');
            $(this).attr('checked', true);
        }
    });

    $(".btn-report").on('click', function (e) {
        let data = $(this).data('options');
        let form = $("#formValidate");

        form.append(`<input type="hidden" name="report_type" value="${data}">`);
        form.submit();
    });

    $("form#formValidate").validate({
        ignore: '',
        errorElement: 'span',
        errorClass: 'is-invalid help-block help-block-error text-danger',
        focusInvalid: true,
        invalidHandler: function(event, validator) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Some fields is required !'
            }).then(() => {
                const btn = $(".btn-submit");
                btn.attr('data-kt-indicator', 'off');
                btn.removeAttr('disabled');
            });
        },
        submitHandler: function(form, e) {
            let url = $(form).attr('data-action');
            $.ajax({
                url: url,
                type: 'POST',
                data: $(form).serializeArray(),
                success: function(resp) {
                    console.log(resp);
                },
                error: function (err) {
                    console.log(err);
                }
            }).done(function(){
                const btn = $(".btn-submit");
                btn.attr('data-kt-indicator', 'off');
                btn.removeAttr('disabled');
            });
        }
    });
});