$(document).ready(function () {
    if (!$('form.mensajes-chat').length) return;

    $(document).on('submit', 'form.mensajes-chat', enviarMensajeChat);

    var socket = io(socketUrl);

    socket.on('aconcloud-channel:App\\Events\\MensajeChatEnviado', function (data) {
        if (data.inquilino_id == inquilino_id) {
            var mensaje = data.mensaje;
            var form = $('form.mensajes-chat');
            var item_id = form.data('item_id');
            var item_type = form.data('item_type');

            if (mensaje.autor_id != user_id && mensaje.item_id == item_id && mensaje.item_type == item_type) {
                mensajeEnviado(data);
            }
        }
    });

    $("#panel-chat-body").animate({scrollTop: 999999});
    function enviarMensajeChat(e) {
        e.preventDefault();

        var form = $(e.target).closest('form.mensajes-chat');
        if (form.find('#message').val() != "") {
            var postData = {
                item_id: form.data('item_id'),
                item_type: form.data('item_type'),
                message: form.find('#message').val(),
            };

            $('#message').val("");
            $.post(baseUrl + "mensajes-chat", postData, mensajeEnviado);
        }
    }

    function mensajeEnviado(data) {
        var mensaje = data.mensaje;

        var html = '';
        html += '<li class="' + ( (mensaje.autor_id == user_id) ? 'right' : 'left') + '">';
        html += '<span class="date-time">' + mensaje.tiempo_display + '</span>';
        html += '<a href="#" class="name">' + ( (mensaje.autor_id == user_id) ? 'Yo' : mensaje.nombre_completo) + '</a>';
        html += '<a href="#" class="image"><img alt="" src="' + mensaje.autor.ruta_imagen_perfil + '" /></a>';
        html += '<div class="message">';
        html += mensaje.message;
        html += '</div></li>';

        $('#lista-mensajes-chat').append(html);

        if (mensaje.autor_id != user_id) {
            var aSound = document.createElement('audio');
            aSound.setAttribute('src', baseUrl + 'build/sounds/new.mp3');
            aSound.play();
        }

        $("#panel-chat-body").animate({scrollTop: 999999});
    }
});

