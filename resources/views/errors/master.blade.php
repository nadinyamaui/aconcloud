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
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link media="all" type="text/css" rel="stylesheet"
          href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link media="all" type="text/css" rel="stylesheet" href="{{elixir('compiled/app.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{elixir('compiled/less.css')}}">
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
            <!-- begin #content -->
    <div id="content" class="content @yield('css-content')">
        @yield('contenido')
        <footer>
        </footer>
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
<script src="{{elixir('compiled/ie9.js')}}"></script>
<![endif]-->

@yield('javascript')
@yield('css')

<h4>
    <div id="contenedorEspera" class="alert alert-warning navbar-fixed-top" style="display: none;"></div>
</h4>
<h4>
    <div id="contenedorCorrecto" class="alert alert-success navbar-fixed-top" style="display: none;"></div>
</h4>
<h4>
    <div id="contenedorError" class="alert alert-danger navbar-fixed-top" style="display: none;"></div>
</h4>

<script>
    var baseUrl = '{{url('')}}/';
    var socketUrl = '{{env('SOCKET_URL')}}';
    var user_id = '{{Auth::id()}}';
    $(document).ready(function () {
        App.init();
    });


</script>

<script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>

</body>
</html>