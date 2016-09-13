<div class="modal-dialog">
    <div class="modal-content">
        {!!Form::model($archivo, ['url'=>'archivos','class'=>'saveajax','data-callback'=>'archivoCargado', 'files'=>true])!!}
        {!!Form::hidden('id')!!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Cerrar</span>
            </button>
            <h4 class="modal-title">Agregar/ Editar archivo</h4>
        </div>
        <div class="modal-body">
            {!!Form::hidden('id')!!}
            {!!Form::hidden('item_id')!!}
            {!!Form::hidden('item_type')!!}
            <div class="row">
                @if($archivo->exists)
                    {!!Form::simple('nombre', 12)!!}
                @else
                    {!!Form::simple('nombre', 6)!!}
                    {!!Form::simple('ruta', 6, 'file')!!}
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        {!!Form::close()!!}
    </div>
</div>