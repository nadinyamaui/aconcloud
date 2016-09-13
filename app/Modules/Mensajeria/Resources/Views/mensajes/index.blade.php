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
                    <!-- begin btn-group -->
                    <div class="btn-group pull-right">
                        @if($mensajes->currentPage()-1>0)
                            <a class="btn btn-white btn-sm" href="{{url("modulos/mensajeria/mensajes?bandeja=".Input::get('bandeja').'&page='.($mensajes->currentPage()-1))}}">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                        @endif
                        <a class="btn btn-white btn-sm" href="{{url("modulos/mensajeria/mensajes?bandeja=".Input::get('bandeja').'&page='.($mensajes->currentPage()+1))}}">
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>
                    <!-- end btn-group -->
                    <!-- begin btn-group -->
                    <div class="btn-group">
                        <button class="btn btn-sm btn-white hide" data-email-action="borrar"><i class="fa fa-times m-r-3"></i> <span class="hidden-xs">Borrar</span></button>
                        <button class="btn btn-sm btn-white hide" data-email-action="papelera"><i class="fa fa-trash m-r-3"></i> <span class="hidden-xs">Enviar a la papelera</span></button>
                    </div>
                    <!-- end btn-group -->
                </div>
                <!-- end btn-toolbar -->
            </div>
            <!-- end wrapper -->
            <!-- begin list-email -->
            <ul class="list-group list-group-lg no-radius list-email">
                @foreach($mensajes as $mensaje)
                    <li class="list-group-item inverse">
                        <div class="email-checkbox">
                            <label>
                                <i class="fa fa-square-o"></i>
                                <input type="checkbox" data-checked="email-checkbox" value="{{$mensaje->id}}" class="mensaje-ids">
                            </label>
                        </div>
                        <div class="email-info">
                            <span class="email-time">{{$mensaje->created_at->format('d/m/Y')}}</span>
                            <h5 class="email-title">
                                {!!link_to('modulos/mensajeria/mensajes/'.$mensaje->id, $mensaje->asunto)!!}
                            </h5>
                        </div>
                    </li>
                @endforeach
            </ul>
            <!-- end list-email -->
            <!-- begin wrapper -->
            <div class="wrapper bg-silver-lighter clearfix">
                <div class="btn-group pull-right">
                    @if($mensajes->currentPage()-1>0)
                        <a class="btn btn-white btn-sm" href="{{url("modulos/mensajeria/mensajes?bandeja=".Input::get('bandeja').'&page='.($mensajes->currentPage()-1))}}">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                    @endif
                    <a class="btn btn-white btn-sm" href="{{url("modulos/mensajeria/mensajes?bandeja=".Input::get('bandeja').'&page='.($mensajes->currentPage()+1))}}">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
                <div class="m-t-5">{{$mensajes->count()}} mensajes</div>
            </div>
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
    </div>
@endsection
@section('javascript')
    {!!HTML::script("assets/js/email-inbox-v2.demo.min.js")!!}

    {!!HTML::script("js/modulos/mensajeria/mensajes.js")!!}
    <script>
        $(document).ready(function() {
            InboxV2.init();
        });
    </script>
@endsection