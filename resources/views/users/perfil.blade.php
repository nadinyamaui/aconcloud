@extends('layouts.master')
@section('contenido')
    <ol class="breadcrumb pull-right">
        <li><a href="#">Usuarios</a></li>
        <li><a class="active" href="#">Perfil</a></li>
    </ol>
    <h1 class="page-header">Mi Perfil</h1>

    <div class="profile-container">
        <!-- begin profile-section -->
        <div class="row">
            <!-- begin profile-left -->
            <div class="col-md-3">
                <!-- begin profile-image -->
                <div class="profile-image dropzone_preview">
                    <img src="{{ $loggedUser->ruta_imagen_perfil }}" id="imagen_perfil" class="drop-files-in-div" data-url="{{ url('users/foto') }}" data-target_div="imagen_perfil"/>
                    <i class="fa fa-user hide"></i>
                </div>
                <!-- end profile-image -->

                <div class="m-b-10">
                    <a href="#" class="btn btn-warning btn-block btn-sm drop-files-in-div" data-url="{{ url('users/foto') }}" data-target_div="imagen_perfil">Cambiar foto</a>
                </div>
            </div>
            <!-- end profile-left -->

            <!-- begin profile-right -->
            <div class="col-md-9">
                <!-- begin profile-info -->
                <div class="profile-info">

                    @include('templates.mensaje')
                    {!!Form::model($user, ['url'=>'users/perfil', 'dont_create_url'=>true])!!}

                    <h4>{{$user->nombre_completo}}</h4>
                    <div class="row" style="display: -webkit-box;">
                        {!!Form::simple('nombre', 4)!!}
                        {!!Form::simple('apellido', 4)!!}
                        {!!Form::simple('cedula', 4)!!}
                    </div>
                    <div class="row" style="display: -webkit-box;">
                        {!!Form::simple('email', 4)!!}
                        {!!Form::simple('telefono_celular', 4)!!}
                        {!!Form::simple('telefono_otro', 4)!!}
                    </div>
                    <div class="row" style="display: -webkit-box;">
                        {!!Form::simple('ind_recibir_gastos_creados', 3)!!}
                        {!!Form::simple('ind_recibir_gastos_modificados', 3)!!}
                        {!!Form::simple('ind_recibir_ingresos_creados', 3)!!}
                        {!!Form::simple('ind_recibir_ingresos_modificados', 3)!!}
                    </div>
                    <div class="row" style="display: -webkit-box;">
                        {!!Form::simple('ind_autenticacion_en_dos_pasos', 3)!!}
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary "><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>

                            <a type="button" class="btn btn-default" href="{{url('users/perfil')}}"><i class="glyphicon glyphicon-trash"></i> Cancelar
                            </a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- end profile-info -->
            </div>
            <!-- end profile-right -->
        </div>
        <!-- end profile-section -->
    </div>
    <!-- end profile-container -->
@endsection