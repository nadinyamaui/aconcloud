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
        <div class="vertical-box-column bg-white">
            <!-- begin wrapper -->
            <div class="wrapper bg-silver-lighter clearfix">
                <div class="btn-group m-r-5">
                    <a href="{{url('modulos/mensajeria/mensajes/create?destinatario_id='.$mensaje->remitente_id)}}" class="btn btn-white btn-sm"><i class="fa fa-reply"></i></a>
                </div>
                <div class="btn-group m-r-5">
                    <a href="#" class="btn btn-white btn-sm p-l-20 p-r-20"><i class="fa fa-trash"></i></a>
                    <a href="{{url('modulos/mensajeria/mensajes/create')}}" class="btn btn-white btn-sm p-l-20 p-r-20"><i class="fa fa-file"></i></a>
                </div>
            </div>
            <!-- end wrapper -->
            <!-- begin wrapper -->
            <div class="wrapper">
                <h4 class="m-b-15 m-t-0 p-b-10 underline">{{$mensaje->asunto}}</h4>
                <ul class="media-list underline m-b-20 p-b-15">
                    <li class="media media-sm clearfix">
                        <div class="media-body">
                                    <span class="email-from text-inverse f-w-600">
                                        De: {{$mensaje->remitente->nombre_completo}}

                                    </span><span class="text-muted m-l-5"><i class="fa fa-clock-o fa-fw"></i> {{$mensaje->created_at->format('d/m/y G:i a')}}</span><br>
                                    <span class="email-to">
                                        Para: {{$mensaje->destinatario->nombre_completo}}
                                    </span>
                        </div>
                    </li>
                </ul>
                <iframe style="width: 100%;" frameborder="0" scrolling="no"
                        src="{{url('modulos/mensajeria/mensajes/iframe/'.$mensaje->id)}}" onload='resizeIframe(this);'>

                </iframe>
            </div>
            <!-- end wrapper -->
            <!-- begin wrapper -->
            <div class="wrapper bg-silver-lighter text-right clearfix">

            </div>
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
    </div>
@endsection
@section('javascript')
    {!!HTML::script("assets/js/email-inbox-v2.demo.min.js")!!}
    {!!HTML::script("js/ckeditor/ckeditor.js")!!}
    <script>
        $(document).ready(function() {
            InboxV2.init();
        });
        function resizeIframe(obj) {
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }
    </script>
@endsection