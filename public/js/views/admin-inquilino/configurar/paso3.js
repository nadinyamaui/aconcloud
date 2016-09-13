/**
 * Created by developer on 12-03-2015.
 */
$(document).ready(function () {
    $('#add-tipo-vivienda').click(function () {
        var parent = $('#template-tipo-vivienda').parent();
        var row = $('#template-tipo-vivienda').clone();
        row.show();
        row.removeAttr('id');
        parent.append('<tr>' + row.html() + '</tr>');
        ajaxCompletado();
    });

    $(document).on('click', '.delete-tipo-vivienda', function () {
        $(this).closest('tr').remove();
        recalcularTotal();
    });
    $(document).on('change', '.cantidad-apartamentos', recalcularFila);
    $(document).on('change', '.porcentaje-pago', recalcularFila);
    $(document).on('change', '.total-porcentaje', recalcularFila);
    recalcularTotal();
});
function recalcularFila(evt) {
    var fila = $(evt.target).closest('tr');
    var cantApto = fila.find('#cantidad_apartamentos').val();
    var porcPago = fila.find('#porcentaje_pago').autoNumeric('get');
    var totalPorc = fila.find('#total_porcentaje').autoNumeric('get');
    if ($(evt.target).attr('id') == 'total_porcentaje') {
        fila.find('#porcentaje_pago').autoNumeric('set', totalPorc / cantApto);
    } else {
        fila.find('#total_porcentaje').autoNumeric('set', cantApto * porcPago);
    }
    recalcularTotal();
}
function recalcularTotal() {
    var total = 0;
    $('.total-porcentaje').each(function () {
        total += parseFloat($(this).autoNumeric('get'));
    });
    $('#total_porcentaje_global').autoNumeric('set', total);
}
