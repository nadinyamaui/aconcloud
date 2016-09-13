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

    $('[id=forma_pago]').each(function () {
        $(this).on('change', function () {
            var parent = $(this).closest('.form-group').parent();
            if (parent.find('input[name=forma_pago]:checked').val() == "efectivo") {
                $('#gasto-banco').hide();
                $('#gasto-efectivo').show();
                $("#gasto-no-comun").hide();
            } else {
                $('#gasto-efectivo').hide();
                $('#gasto-banco').show();
                $("#gasto-no-comun").show();
            }
        });

        $(this).trigger('change');
    });

    $('[id=origen_dinero]').each(function () {
        $(this).on('change', function () {
            var parent = $(this).closest('.form-group').parent();
            if (parent.find('input[name=origen_dinero]:checked').val() == "cuenta") {
                $('#origen-dinero-cuenta').show();
                $('#origen-dinero-fondo').hide();
                $("#fondo_id").val("");
            } else {
                $('#origen-dinero-cuenta').hide();
                $('#origen-dinero-fondo').show();
                $("#cuenta_id").val("");
            }
        });

        $(this).trigger('change');
    });
});
