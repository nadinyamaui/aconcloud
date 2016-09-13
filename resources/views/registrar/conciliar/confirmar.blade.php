<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Cerrar</span>
            </button>
            <h4 class="modal-title">Verificar conciliación de movimientos</h4>
        </div>
        <div class="modal-body">
            @include('templates.errores')
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        <legend>Ingreso/ Egreso</legend>
                    </fieldset>
                    <div class="row">
                        {!!Form::display($ingreso, 'referencia')!!}
                        {!!Form::display($ingreso, 'monto')!!}
                        {!!Form::display($ingreso, 'tipo_movimiento')!!}
                        {!!Form::display($ingreso, 'comentarios')!!}
                    </div>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>Estado de cuenta</legend>
                    </fieldset>
                    <div class="row">
                        {!!Form::display($estado, 'referencia')!!}
                        {!!Form::display($estado, 'monto')!!}
                        {!!Form::display($estado, 'tipo_movimiento')!!}
                        {!!Form::display($estado, 'descripcion')!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {!!Form::open(['url'=>'registrar/conciliar/confirmar'])!!}
            {!!Form::hidden('ingreso_id', $ingreso->id)!!}
            {!!Form::hidden('estado_id', $estado->id)!!}
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            @if(count($errors)==0)
                <button type="submit" class="btn btn-primary">Conciliar</button>
            @endif
            {!!Form::close()!!}
        </div>
    </div>
</div>