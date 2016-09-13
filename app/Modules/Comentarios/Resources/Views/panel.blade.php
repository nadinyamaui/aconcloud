<div class="col-md-{{$cols or 12}}">
    <!-- begin panel -->
    <div class="panel panel-inverse">
        @include('templates.panel-header', ['titulo'=>'Comentarios'])
        <div class="panel-body">
            {!!Form::model($comentarioNuevo, ['url'=>'modulos/comentarios/comentarios','class'=>'saveajax','data-callback'=>'comentarioGuardado'])!!}
            {!!Form::hidden('cols', $cols)!!}
            {!!Form::hidden('item_id')!!}
            {!!Form::hidden('item_type')!!}
            <div class="row">
                {!!Form::simple('comentario', 12, 'textarea')!!}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary "><i class="glyphicon glyphicon-floppy-disk"></i>
                        Comentar
                    </button>
                </div>
            </div>
            {!!Form::close()!!}
            <hr>
            @foreach($comentarios as $comentario)
                <div class="media media-sm">
                    <div class="media-body">
                        <h5 class="media-heading">{{$comentario->autor->nombre_completo}}
                            <div class="pull-right">
                                <small>{{$comentario->created_at->format('d/m/Y h:i A')}}</small>
                            </div>
                        </h5>
                        @if($comentario->puedeEliminar())
                            <a class="btn btn-danger btn-xs boton-eliminar pull-right"
                               data-callback="comentarioGuardado" href="#"
                               data-url="{{url('modulos/comentarios/comentarios/'.$comentario->id.'?cols='.$cols)}}"><i
                                        class="glyphicon glyphicon-trash"></i></a>
                        @endif
                        <p>{{$comentario->comentario}}</p>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    <!-- end panel -->
</div>