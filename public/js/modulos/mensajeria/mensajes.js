$(document).ready(function () {
    $(document).on("click", "[data-email-action]", function () {
        var accion = $(this).data("email-action");
        var ids = [];
        $('.mensaje-ids:checked').each(function () {
            ids.push($(this).val());
        });

        $.post(baseUrl + "modulos/mensajeria/mensajes/" + accion, {ids: ids}, function () {
            var targetEmailList = '[data-checked=email-checkbox]:checked';
            if ($(targetEmailList).length !== 0) {
                $(targetEmailList).closest('li').slideToggle(function () {
                    $(this).remove();
                    handleEmailActionButtonStatus();
                });
            }
        });
    });
});
