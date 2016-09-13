<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>Aconcloud - @yield('titulo')</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>

    <link media="all" type="text/css" rel="stylesheet" href="{{elixir('compiled/app.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{elixir('compiled/less.css')}}">
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    @include('layouts.header')
    @include('layouts.sidebar')
            <!-- begin #content -->
    <div id="content" class="content @yield('css-content')">
        @yield('contenido')

        <div class="row">
            @if(isset($panelesAdicionales))
                @foreach($panelesAdicionales as $panel)
                    @if(isset($panel['html']) && $panel['html'] != "")
                        <div id="panel-{{$panel['id']}}">
                            {!! $panel['html'] !!}
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <footer>
        </footer>
    </div>
    <!-- end #content -->
    <div id="footer" class="footer">
        &copy;{{date('Y')}} Aconcloud - Todos los derechos reservados
    </div>
    <!-- begin scroll to top btn -->
    <a href="javascript:" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i
                class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->
<script src="{{elixir('compiled/jquery.js')}}"></script>
<script src="{{elixir('compiled/jquery-migrate.js')}}"></script>
<script src="{{elixir('compiled/plugins.js')}}"></script>
<script src="{{elixir('compiled/app.js')}}"></script>
<script src="{{elixir('compiled/lang/es.js')}}"></script>

<!--[if lt IE 9]>
<script src="{{url('compiled/ie9.js')}}"></script>
<![endif]-->

@yield('javascript')
@yield('css')
<div class="modal fade" id="modalConfirmacion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title">Ventana de confirmación</h4>
            </div>
            <div class="modal-body">
                <p id='mensajeModalConfirmacion'></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button id="okModalConfirmacion" type="button" class="btn btn-danger">Si</button>
            </div>
        </div>
    </div>
</div>
<h4>
    <div id="contenedorEspera" class="alert alert-warning navbar-fixed-top" style="display: none;"></div>
</h4>
<h4>
    <div id="contenedorCorrecto" class="alert alert-success navbar-fixed-top" style="display: none;"></div>
</h4>
<h4>
    <div id="contenedorError" class="alert alert-danger navbar-fixed-top" style="display: none;"></div>
</h4>
<div class="modal fade" id="divModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"></div>
<div class="modal fade" id="divModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"></div>
<script>
    var baseUrl = '{{url('')}}/';
    var socketUrl = '{{url('')}}:3000';
    var inquilino_id = '{{$inquilinoActivo->id}}';
    var user_id = '{{Auth::id()}}';
    $(document).ready(function () {
        App.init();
    });
</script>

</body>
</html>