$(document).ready(function () {
    $("#total_relacion").prop('disabled', true);

    $("#vivienda_id").change(function () {
        var url = $("table").data("url");
        tables[0].ajax.url(url + $(this).val()).load();

        $.getJSON(baseUrl + "admin-inquilino/viviendas/" + $(this).val(), function (vivienda) {
            $('#saldo_deudor').text(accounting.formatMoney(vivienda.saldo_deudor, ""));
            $('#saldo_a_favor').text(accounting.formatMoney(vivienda.saldo_a_favor, ""));
        });
    });
    $(document).on("change", "#pagado", function () {
        var monto = 0;
        var table = $(this).closest('table');
        $(table).find('tr').each(function () {
            var chk = $(this).find('input[type="checkbox"]');
            if (chk.prop('checked')) {
                monto += accounting.unformat($(this).find("td").eq(3).html(), ",");
            }
        });

        $("#total_relacion").autoNumeric('set', monto);
    });

    $("#monto_pagado").change(function () {
        $("input[id='pagado']").prop('checked', false);
        $('tr').removeClass('active');
        var saldoAFavor = parseFloat(accounting.unformat($('#saldo_a_favor', "")));
        var montoDisponible = parseFloat($("#monto_pagado").autoNumeric('get')) + saldoAFavor;
        $('table').find('tr').each(function () {
            var chk = $(this).find('input[id="pagado"]');
            var monto = accounting.unformat($(this).find("td").eq(3).html(), ",");
            if (montoDisponible - monto >= 0) {
                chk.prop("checked", true);
                chk.trigger("change");
                chk.closest("tr").addClass("active");
                montoDisponible -= monto;
            }
        });
    });
    $("#vivienda_id").trigger("change");
});

$(document).ajaxComplete(function () {
    $("input[id='pagado']").prop('disabled', true);
});