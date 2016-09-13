@extends('auth.layout')
@section('titulo')
    Inicio de sesión ({{$inquilino->nombre}})
@endsection
@section('contenido')
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated flipInX">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> {{$inquilino->nombre}}
            </div>
            <div class="icon">
                <i class="fa fa-sign-in"></i>
            </div>
        </div>
        <!-- end brand -->
        <div class="login-content">
            @include('templates.mensaje')
            {!!Form::open(['open'=>'auth/login','class'=>'margin-bottom-0'])!!}
            <div class="form-group m-b-20">
                <input type="text" class="form-control input-lg" placeholder="Correo" name="email"/>
            </div>
            <div class="form-group m-b-20">
                <input type="password" class="form-control input-lg" placeholder="Contraseña" name="password"/>
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-success btn-block btn-lg">Entrar</button>
            </div>
            <div class="m-t-20">
                 <a href="{{url('password/email')}}">¿Olvidaste tu contraseña?</a>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    <!-- end login -->
@endsection