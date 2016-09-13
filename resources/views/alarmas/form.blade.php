@extends('admin.ayudas.layout')
@section('contenido2')
    @if($ayuda->id)
        @include('templates.panel-header', ['titulo'=>'Modificar la ayuda/ tutorial'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear una ayuda/ tutorial'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($ayuda, ['url'=>'admin/ayudas'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('titulo', 5)!!}
            {!!Form::simple('tipo_ayuda_id', 3)!!}
            {!!Form::simple('descripcion', 4, 'textarea')!!}
        </div>
        <div class="row">
            {!!Form::simple('contenido', 12, 'textarea', ['class'=>'ckeditor '])!!}
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script("js/ckeditor/ckeditor.js")!!}
@endsection