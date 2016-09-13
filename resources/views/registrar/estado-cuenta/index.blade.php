@extends('registrar.estado-cuenta.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Cargar estado de cuenta'])
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($movimiento, ['url'=>'registrar/estado-cuenta', 'files'=>true])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('cuenta_id', 6)!!}
            <div class="col-xs-12 col-md-6 form-group">
                <label for="archivo">Estado de cuenta (Formato QIF)</label>
                {!!Form::file('archivo', ['class'=>'form-control','placeholder'=>'Archivo QIF','id'=>'archivo'])!!}
            </div>
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection