<div class="modal-dialog">
    <div class="modal-content">
        {!!Form::model($clasificacion, ['url'=>'admin-inquilino/clasificacion-ingreso-egreso','class'=>'saveajax','data-callback'=>'reloadTables'])!!}
        {!!Form::hidden('id')!!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Cerrar</span>
            </button>
            <h4 class="modal-title">Crear/Editar Clasificación de ingreso o egreso</h4>
        </div>
        <div class="modal-body">
            @include('admin-inquilino.clasificacion-ingreso-egreso._form')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        {!!Form::close()!!}
    </div>
</div>