$(document).ready(function () {

    $('[id=ind_sms]').each(function () {
        $(this).on('change', function () {
            var parent = $(this).closest('.form-group').parent();
            if (parent.find('input[name=ind_sms]:checked').val() == 1) {
                $('#cuerpo-html').hide();
                $('#cuerpo-sms').show();
            } else {
                $('#cuerpo-html').show();
                $('#cuerpo-sms').hide();
            }
        });

        $(this).trigger('change');
    });
});
