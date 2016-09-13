@extends('admin-inquilino.periodo-junta.layout')
@section('contenido2')
    @include('templates.panel-header', ['titulo'=>'Periodos de la junta de condominio'])
    @include('templates.mensaje')
    <div class="panel-body">
        {!!HTML::tableAjax('App\Models\Inquilino\PeriodoJunta', $columns)!!}
    </div>
@endsection