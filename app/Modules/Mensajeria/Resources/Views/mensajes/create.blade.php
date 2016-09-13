@extends('layouts.master')
@section('css-content')
    content-full-width
@endsection
@section('contenido')
    <div class="vertical-box">
        <!-- begin vertical-box-column -->
        @include('mensajeria::mensajes.sidebar')
        <!-- end vertical-box-column -->
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column">
            <!-- begin wrapper -->
            <div class="wrapper bg-silver-lighter">
                <!-- begin btn-toolbar -->
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="{{url('modulos/mensajeria/mensajes/create')}}" class="btn btn-white btn-sm p-l-20 p-r-20"><i class="fa fa-file"></i></a>
                        <a href="{{url('modulos/mensajeria/mensajes')}}" class="btn btn-white btn-sm p-l-20 p-r-20"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <!-- end btn-toolbar -->
            </div>
            <!-- end wrapper -->
            <!-- begin wrapper -->
            <div class="wrapper">
                <div class="p-30 bg-white">
                    @include('templates.mensaje')
                    {!!Form::model($mensaje, ['url'=>'modulos/mensajeria/mensajes'])!!}
                    <div class="row">
                        {!!Form::simple('destinatarios[]', 12, 'multiselect', [], $usuarios)!!}
                    </div>
                    <div class="row">
                        {!!Form::simple('asunto', 12)!!}
                    </div>
                    <div class="row">
                        {!!Form::simple('ind_sms', 12)!!}
                    </div>
                    <div class="row" id="cuerpo-html">
                        {!!Form::simple('cuerpo', 12, 'textarea', ['class'=>'ckeditor '])!!}
                    </div>
                    <div class="row" id="cuerpo-sms" style="display: none">
                        {!!Form::simple('cuerpo_sms', 12, 'textarea', ['maxlength'=>'140'])!!}
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary "><i class="fa fa-paper-plane"></i> Enviar Mensaje</button>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
    </div>
@endsection
@section('javascript')
    {!!HTML::script("assets/js/email-inbox-v2.demo.min.js")!!}
    {!!HTML::script("js/ckeditor/ckeditor.js")!!}
    {!!HTML::script("js/modulos/mensajeria/create.js")!!}
    <script>
        $(document).ready(function() {
            InboxV2.init();
        });
    </script>
@endsection