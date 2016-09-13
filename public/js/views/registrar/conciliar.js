$(document).ready(function () {
    $('#ingresos-egresos tr').click(marcarSeleccionado);
    $('#estado-cuenta tr').click(marcarSeleccionado);

    function marcarSeleccionado(evt) {
        var target = $(evt.target).closest('tr');
        if (target.hasClass('active')) {
            target.removeClass('active');
        } else {
            target.closest('tbody').find('tr').removeClass('active');
            target.addClass('active');
            verificarMovimientos();
        }

    }

    function verificarMovimientos() {
        var aux = $('#ingresos-egresos tr').hasClass('active');
        var aux2 = $('#estado-cuenta tr').hasClass('active');
        if (aux && aux2) {
            var ingreso = $('#ingresos-egresos').find('tr.active').data('id');
            var estado = $('#estado-cuenta').find('tr.active').data('id');
            abrirModal(baseUrl + "registrar/conciliar/confirmar/" + ingreso + "/" + estado);
        }
    }
});
