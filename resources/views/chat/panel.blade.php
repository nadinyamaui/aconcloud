<!-- begin panel -->
<div class="panel panel-inverse" id="panel-chat">
    @include('templates.panel-header', ['titulo'=> $titulo])
    <div class="panel-body bg-silver" id="panel-chat-body" style="overflow-y: scroll;height: 300px;">
        <ul class="chats" id="lista-mensajes-chat">
            @foreach($mensajes as $mensaje)
                <li class="{{$mensaje->es_autor ? 'right':'left'}}" data-id="{{$mensaje->id}}">
                    <span class="date-time">{{$mensaje->tiempo_display}}</span>
                    <a href="#" class="name">{{$mensaje->es_autor ? 'Yo':$mensaje->autor->nombre_completo}}</a>
                    <a href="#" class="image"><img alt="" src="{{ $mensaje->autor->ruta_imagen_perfil }}"/></a>

                    <div class="message">
                        {!! $mensaje->message !!}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="panel-footer">
        <form class="mensajes-chat" data-item_id="{{$item->id}}" data-item_type="{{get_class($item)}}">
            <div class="input-group">
                <input type="text" class="form-control input-sm" name="message" id="message"
                       placeholder="Escribe tu mensaje aqui.">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-sm" type="submit">Enviar</button>
                                    </span>
            </div>
        </form>
    </div>
</div>
<!-- end panel -->