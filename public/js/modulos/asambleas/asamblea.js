$(document).ready(function () {
    $(document).on("click", ".boton-asamblea-asistencia", function () {
        var id = $(this).data('id');
        var value = $(this).find('#ind_asistio').val();
        var data = {
            asistente_id: id,
            estatus: value
        };

        $.post(baseUrl+"modulos/asambleas/asambleas/"+asamblea_id+"/asistentes/estatus", data);
    });
});
