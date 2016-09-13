var tables = [];
accounting.settings = {
    currency: {
        symbol: "Bs",   // default currency symbol is '$'
        format: "%s%v", // controls output: %s = symbol, %v = value/number (can be object: see below)
        decimal: ",",  // decimal point separator
        thousand: ".",  // thousands separator
        precision: 2   // decimal places
    },
    number: {
        precision: 2,  // default precision on numbers is 0
        thousand: ".",
        decimal: ","
    }
};

$(document).ready(function () {
    $('.drop-files-in-div').each(function(){
        var url = $(this).data('url');
        var target = "#"+$(this).data('target_div');
        $(this).dropzone({
            url: url,
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            addRemoveLinks: false,
            acceptedFiles: "image/*",
            previewsContainer: ".dropzone_preview",
            sending: function (param1, param2, formData) {
                $(target).hide();
                mostrarEspera("Cargando imagen...");
            },
            success: function (file, response) {
                mostrarMensaje(response.mensaje);
                ajaxCompletado();
                var imgUrl = response.object.ruta_imagen_perfil;
                $(target).attr('src', imgUrl);
                this.removeFile(file);
                $(target).show();
                $("[id=contenedorEspera]").each(function () {
                    $(this).fadeOut(500);
                });
            },
            error: function (file, response) {
                mostrarError(procesarErrores(response.errores));
            }
        });
    });

    $('.same-height').equalize();
    $(document).on('click', '.btn-volver', function (evt) {
        var urlAtras = location.href;
        sect = urlAtras.split('?')[0].split('/');
        console.log(sect);
        if (!isNaN(sect[sect.length - 2])) {
            delete sect[sect.length - 1];
            delete sect[sect.length - 2];
        } else {
            delete sect[sect.length - 1];
        }
        var url = sect.join('/');
        while (url.endsWith("/")) {
            url = url.slice(0, -1);
        }
        location.href = url;
    });

    $('.jqueryDatePicker').datepicker({
        todayHighlight: true,
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "es",
        autoclose: true
    });

    //eventos delegados al document..
    $(document).on('click', '.abrir-modal', function (evt) {
        evt.preventDefault();
        abrirModal($(this).attr('href'));
    });

    $(document).on('submit', 'form.saveajax', function (e) {
        var data, contenido;
        if ($(this).attr('enctype') == "multipart/form-data") {
            data = new FormData(this);
            contenido = false;
        } else {
            data = $(this).serialize();
            contenido = 'application/x-www-form-urlencoded; charset=UTF-8';
        }
        $(this).find('input, textarea, select').parent().removeClass("has-error");
        $(this).find('.help-block').remove();
        var form = this;
        $.ajax({
            url: $(this).attr('action'),
            data: data,
            cache: false,
            processData: false,
            contentType: contenido,
            formulario: form,
            dataType: 'json',
            method: $(this).attr("method") == undefined ? "POST" : $(this).attr("method"),
            success: function (data) {
                console.log(data);

                if (data.mensaje != "") {
                    mostrarMensaje(data.mensaje);
                }
                var callback = $(this.formulario).attr('data-callback');
                if (callback != undefined && callback != "") {
                    window[callback](data);
                }
                if (data.vista != undefined) {
                    $(this.formulario).parent().html(data.vista);
                }
            },
            error: function (data) {
                var formulario = this.formulario;
                if (data.status == 400) {
                    var errores = $.parseJSON(data.responseText);
                    mostrarError(procesarErrores(errores));
                    $.each(errores, function (key, value) {
                        $('#' + key).parent().addClass('has-error has-feedback');
                        $.each(value, function (key2, value2) {
                            $(formulario).find('#' + key).parent().append("<span class='help-block'>" + value2 + "</span>");
                        });
                    });
                }
            }
        });
        e.preventDefault();
    });

    $(".decimal-format").autoNumeric('init', {
        aSep: ".",
        aDec: ",",
        vMin: -999999999999999999999
    });

    $(".decimal-format").css('text-align', 'right');

    $('.responsive-datatable').each(function () {
        var options = {
            stateSave: true,
            responsive: true,
            "deferRender": true,
            "aaSorting": [],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        };
        if (this.hasAttribute("data-url")) {
            var url = window.location.href.split('?'), finalUrl;
            if (url[1] != undefined && $(this).data('url').indexOf('?') === -1) {
                finalUrl = $(this).data('url') + "?" + url[1];
            } else if (url[1] != undefined) {
                finalUrl = $(this).data('url') + "&" + url[1];
            } else {
                finalUrl = $(this).data('url');
            }
            var table = this;
            options.serverSide = true;
            options.ajax = {
                url: finalUrl,
                type: 'POST',
                "data": function (d) {
                    d.modal = $(table).data('modal');
                    d.url = $(table).data('edit_url');
                    d.has_show = $(table).data('has_show');
                    d.has_edit = $(table).data('has_edit');
                    d.has_delete = $(table).data('has_delete');
                    d.table_columns = $(table).closest('.row').find('#table_columns').val();
                }
            }
        }
        tables.push($(this).DataTable(options));
    });


    $(document).on('click', '.boton-eliminar', function (evt) {
        evt.preventDefault();
        var url, target = evt.target;
        if ($(target).is('a')) {
            url = $(target).data('url');
        } else {
            url = $(target).closest('a').data('url');
            target = $(target).closest('a');
        }
        confirmarIntencion("¿Esta seguro que desea eliminar el elemento seleccionado?", function () {
            var callback = $(target).data('callback');
            var reload = $(target).data('reload');
            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                cache: false,
                processData: false,
                success: function (data) {
                    mostrarMensaje(data.mensaje);
                    reloadTables();
                    console.log(reload);
                    if (callback != undefined && callback != "") {
                        window[callback](data);
                    } else if (reload != undefined) {
                        console.log("ENtre");
                        location.reload();
                    }
                },
                error: function (data, otro, otromas, otrdlfkd) {
                    var json = $.parseJSON(data.responseText);
                    mostrarError(json.error);
                }
            });
        });
    });
    ajaxCompletado();
});

$(document).ajaxComplete(function () {
    $("[id=contenedorEspera]").each(function () {
        $(this).fadeOut(500);
    });
    ajaxCompletado();
});

$(document).ajaxStart(function () {
    mostrarEspera("Por favor espere.");
});

$.ajaxSetup({
    statusCode: {
        500: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Error interno del servidor)</i>");
        },
        401: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Es necesaria autenticación)</i>");
        },
        403: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(El sistema denegó el acceso al recurso)</i>");
        },
        404: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Página no encontrada)</i>");
        },
        410: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Recurso no encontrado)</i>");
        }
    }
});


function mostrarMensaje(mensaje) {
    $("[id=contenedorCorrecto]").each(function () {
        $(this).fadeIn(500);
        $(this).html("<span class='fa fa-check fa-fw'></span> " + mensaje);
    });
    setTimeout(function () {
        $("[id=contenedorCorrecto]").each(function () {
            $(this).fadeOut(500);
        });
    }, 4000);
}

function mostrarEspera(mensaje) {
    $("[id=contenedorEspera]").each(function () {
        $(this).fadeIn(500);
        $(this).html("<img src='" + baseUrl + "build/images/loader.gif'> " + mensaje);
    });
}
function mostrarError(mensaje) {
    $("[id=contenedorError]").each(function () {
        $(this).fadeIn(500);
        $(this).html(mensaje);
    });
    setTimeout(function () {
        $("[id=contenedorError]").each(function () {
            $(this).fadeOut(500);
        });
    }, 4000);
}

function procesarErrores(errores) {
    var mensaje = "";
    try {
        $.each(errores, function (key, value) {
            $.each(value, function (key2, value2) {
                mensaje += "<span class='glyphicon glyphicon-remove'></span> " + value2 + "</br>";
            });
        });
    } catch (err) {
        return mensaje = "<span class='glyphicon glyphicon-remove'></span> " + errores + "</br>";
    }
    return mensaje;
}

function confirmarIntencion(mensaje, confirmado) {
    $('#modalConfirmacion').modal('show');
    $('#mensajeModalConfirmacion').html(mensaje);
    $('#okModalConfirmacion').unbind('click');
    $('#okModalConfirmacion').click(confirmado);
    $('#okModalConfirmacion').click(function () {
        $('#modalConfirmacion').modal('hide');
    });
}

function ajaxCompletado() {
    $(".decimal-format").autoNumeric('init', {
        aSep: ".",
        aDec: ",",
        vMin: -999999999999999999999
    });
    $(".decimal-format").css('text-align', 'right');
    $('select.advanced-select').select2({
        language: "es"
    });

    $("input[type='radio']:checked").each(function () {
        $(this).parent().addClass('active');
    });
}

function abrirModal(url) {
    $.get(url, function (data) {
        if ($("#divModal").is(':empty')) {
            $("#divModal").html(data);
            $("#divModal").modal('show');
        } else {
            $("#divModal2").html(data);
            $("#divModal2").modal('show');
        }
    });
}

function reloadPage() {
    window.location.reload();
}

function reloadTables() {
    for (var i = 0; i < tables.length; i++) {
        tables[i].ajax.reload();
    }
    $('.modal').modal('hide');
}

Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "," : d,
        t = t == undefined ? "." : t,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


//Modulos handlers

function comentarioGuardado(data) {
    $("#panel-comentarios").html(data.vista);
}

function archivoCargado(data) {
    if ($('#archivos_cargados').val() != "") {
        $('#archivos_cargados').val($('#archivos_cargados').val() + "," + data.archivo.id);
    } else {
        $('#archivos_cargados').val(data.archivo.id);
    }
    reloadTables();
}