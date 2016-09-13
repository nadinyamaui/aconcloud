@extends('admin-inquilino.periodo-junta.layout')
@section('contenido2')
    @if($periodo->exists)
        @include('templates.panel-header', ['titulo'=>'Modificar el periodo de la junta de condominio'])
    @else
        @include('templates.panel-header', ['titulo'=>'Registrar un nuevo periodo de la junta de condominio'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($periodo, ['url'=>'admin-inquilino/periodo-junta'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('fecha_desde', 6)!!}
            {!!Form::simple('fecha_hasta', 6)!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
        @if($periodo->exists)
            <br>
            <h3>Propietarios miembros de la junta de condominio</h3>
            {!!HTML::tableAjax('App\Models\Inquilino\PeriodoJuntaUser', $columns, true,true,true,false,"admin-inquilino/periodo-junta/".$periodo->id."/users", true)!!}
        @endif
    </div>
@endsection