$(document).ready(function () {
    $(document).on('change', 'input[id=ind_caja_chica]', function () {
        var parent = $(this).closest('.form-group').parent();
        if (parent.find('input[name=ind_caja_chica]:checked').val() == 0) {
            $('#div-monto-caja-chica').hide();
        } else {
            $('#div-monto-caja-chica').show();
        }
    });
    $('input[id=ind_caja_chica]').trigger('change');
});
