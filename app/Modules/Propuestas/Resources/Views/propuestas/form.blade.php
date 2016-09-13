@extends('propuestas::propuestas.layout')
@section('contenido2')
    @if($propuesta->id)
        @include('templates.panel-header', ['titulo'=>'Modificar la propuesta'])
    @else
        @include('templates.panel-header', ['titulo'=>'Proponer una nueva propuesta'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($propuesta, ['url'=>'modulos/propuestas/propuestas'])!!}
        {!!Form::hidden('id')!!}
        {!!Form::hidden('archivos_cargados', '', ['id'=>'archivos_cargados'])!!}
        <div class="row">
            {!!Form::simple('titulo', 8)!!}
            {!!Form::simple('fecha_cierre', 4)!!}
        </div>
        <div class="row">
            {!!Form::simple('autorizados[]', 4, 'multiselect', [], $usuarios)!!}
            {!!Form::simple('ind_enviar_sms', 4)!!}
            {!!Form::simple('ind_enviar_email', 4)!!}
        </div>
        <div class="row">
            {!!Form::simple('propuesta', 12, 'textarea', ['class'=>'ckeditor '])!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script("js/ckeditor/ckeditor.js")!!}
@endsection