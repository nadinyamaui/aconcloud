@extends('auth.layout')
@section('titulo')
    Recuperar contraseña ({{$inquilinoActivo->nombre}})
@endsection
@section('contenido')
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated flipInX">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> {{$inquilinoActivo->nombre}}
            </div>
            <div class="icon">
                <i class="fa fa-sign-in"></i>
            </div>
        </div>
        <!-- end brand -->
        <div class="login-content">
            @include('templates.mensaje')
            @if (session('status'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('status') }}
                </div>
            @endif
            {!!Form::open(['open'=>'password/email','class'=>'margin-bottom-0'])!!}
            <div class="form-group m-b-20">
                <input type="text" class="form-control input-lg" placeholder="Correo" name="email"/>
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-success btn-block btn-lg">Recuperar contraseña</button>
            </div>
            <div class="m-t-20">
                <a href="{{url('auth/login')}}">Volver al inicio de sesión</a>
            </div>
            {!!Form::close()!!}

        </div>
    </div>
    <!-- end login -->
@endsection