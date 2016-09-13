<div class="modal-dialog">
    <div class="modal-content">
        {!!Form::model($user, ['url'=>'admin-inquilino/periodo-junta/'.$periodo->id.'/users','class'=>'saveajax','data-callback'=>'reloadTables'])!!}
        {!!Form::hidden('id')!!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Cerrar</span>
            </button>
            <h4 class="modal-title">Crear/Editar Usuario en la junta de condominio</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                {!!Form::simple('user_id', 6, 'select', [], $usuarios)!!}
                {!!Form::simple('cargo_junta_id', 6)!!}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        {!!Form::close()!!}
    </div>
</div>