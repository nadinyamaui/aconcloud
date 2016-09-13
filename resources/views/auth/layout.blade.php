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

<div class="login-cover">
    <div class="login-cover-image">
        {!!HTML::image("build/images/".App\Helpers\Helper::getTiempoString().".jpg",'',['data-id'=>"login-cover-image"])!!}
    </div>
    <div class="login-cover-bg"></div>
</div>
<!-- begin #page-container -->
<div id="page-container" class="fade">
    @yield('contenido')
</div>
<!-- end page container -->

<script src="{{elixir('compiled/jquery.js')}}"></script>
<script src="{{elixir('compiled/jquery-migrate.js')}}"></script>
<script src="{{elixir('compiled/plugins.js')}}"></script>
<script src="{{elixir('compiled/app.js')}}"></script>

<!--[if lt IE 9]>
<script src="{{url('compiled/ie9.js')}}"></script>
<![endif]-->

<script>
    var baseUrl = '{{url('')}}/';
    var socketUrl = '{{url('')}}:3000';
    var inquilino_id = '{{$inquilinoActivo->id}}';
    var user_id = '{{Auth::id()}}';

    $(document).ready(function () {
        App.init();
        LoginV2.init();
    });
</script>

</body>
</html>
