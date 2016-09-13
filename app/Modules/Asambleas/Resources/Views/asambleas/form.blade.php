@extends('asambleas::asambleas.layout')
@section('contenido2')
    @if($asamblea->id)
        @include('templates.panel-header', ['titulo'=>'Modificar la asamblea'])
    @else
        @include('templates.panel-header', ['titulo'=>'Convocar una nueva asamblea'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($asamblea, ['url'=>'modulos/asambleas/asambleas'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('titulo', 12)!!}
        </div>
        <div class="row">
            {!!Form::simple('fecha', 2)!!}
            {!!Form::simple('hora_inicio', 2, 'select', [], $timeSlots)!!}
            {!!Form::simple('hora_fin', 2, 'select', [], $timeSlots)!!}
            {!!Form::simple('ind_enviar_sms', 3)!!}
            {!!Form::simple('ind_enviar_email', 3)!!}
        </div>
        <div class="row">
            @if(!$asamblea->exists)
                {!!Form::multiselect('propuestas', 6)!!}
            @endif
            {!!Form::simple('youtube_link', 6)!!}
        </div>
        <div class="row">
            @if($asamblea->youtube_embed_link != "")
                <iframe width="420" height="315" frameborder="0" allowfullscreen
                        src="{{$asamblea->youtube_embed_link}}">
                </iframe>
            @endif
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script("js/ckeditor/ckeditor.js")!!}
@endsection