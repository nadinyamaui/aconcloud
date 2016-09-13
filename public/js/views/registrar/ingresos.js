$(document).ready(function () {
    $('[id=ind_movimiento_en_cuotas]').each(function () {
        $(this).on('change', function () {
            var parent = $(this).closest('.form-group').parent();
            if (parent.find('input[name=ind_movimiento_en_cuotas]:checked').val() == 1) {
                $('#movimiento-en-cuotas').show();
            } else {
                $('#movimiento-en-cuotas').hide();
            }
        });

        $(this).trigger('change');
    });
});
