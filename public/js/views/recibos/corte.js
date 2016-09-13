$(document).ready(function () {
    var data = [];
    var url = "graficos/tipo-viviendas/corte?mes=" + $('#mes').val() + "&ano=" + $('#ano').val();
    if ($('#id').val()){
        url = "graficos/tipo-viviendas/corte?corte_id=" + $('#id').val();
    }
    $.get(baseUrl + url, data, function (elements) {
        Morris.Donut({
            element: 'grafico-tipo-vivienda',
            data: elements.data,
            formatter: function (y) {
                return y.formatMoney() + " Bs."
            },
            resize: true
        });
    });

});