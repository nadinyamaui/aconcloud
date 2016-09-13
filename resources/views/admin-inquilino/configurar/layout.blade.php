@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Administración</a></li>
        <li><a href="#">Instalación de Aconcloud</a></li>
        <li class="active">Paso {{$paso}}</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Paso {{$paso}} de 9</h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Paso '.$paso.' de 9'])
                @include('templates.mensaje')
                <div class="panel-body">
                    {!!Form::open(['url'=>'admin-inquilino/configurar/paso'.$paso])!!}
                    <div class="bwizard clearfix">
                        <ol class="bwizard-steps clearfix clickable" role="tablist" style="padding-left: 0;">
                            <li role="tab" aria-selected="true" class="{{$paso==1 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">1</span>
                                <a href="{{url('admin-inquilino/configurar/paso1')}}" class="hidden-phone">
                                    Bienvenida
                                </a>
                                <a href="{{url('admin-inquilino/configurar/paso1')}}" class="hidden-phone">
                                    <small>El equipo de Aconcloud te da la bienvenida.</small>
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==2 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">2</span>
                                <a href="{{url('admin-inquilino/configurar/paso2')}}" class="hidden-phone">
                                    Usuarios del sistema
                                </a>
                                <a href="{{url('admin-inquilino/configurar/paso2')}}" class="hidden-phone">
                                    <small>¿Cuales serán los usuarios de este sistema?</small>
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==3 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">3</span>
                                <a href="{{url('admin-inquilino/configurar/paso3')}}" class="hidden-phone">
                                    Tipos de vivienda
                                </a>
                                <a href="{{url('admin-inquilino/configurar/paso3')}}" class="hidden-phone">
                                    <small>¿Qué tipos de vivienda hay en tu edificio?</small>
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==4 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">4</span>
                                <a href="{{url('admin-inquilino/configurar/paso4')}}" class="hidden-phone">
                                    Viviendas del edificio
                                </a>
                                <a href="{{url('admin-inquilino/configurar/paso4')}}" class="hidden-phone">
                                    <small>¿Qué Vivienda hay en tu edificio?</small>
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==5 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">5</span>
                                <a href="{{url('admin-inquilino/configurar/paso5')}}" class="hidden-phone">
                                    Cuentas bancarias
                                </a>
                                <a href="{{url('admin-inquilino/configurar/paso5')}}" class="hidden-phone">
                                    <small>¿Qué cuentas bancarias maneja tu condominio?</small>
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==6 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">6</span>
                                <a href="{{url('admin-inquilino/configurar/paso6')}}" class="hidden-phone">
                                    Fondos
                                </a>
                                <a href="{{url('admin-inquilino/configurar/paso6')}}" class="hidden-phone">
                                    <small>¿Qué fondos maneja tu condominio?</small>
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==7 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">7</span>
                                <a href="{{url('admin-inquilino/configurar/paso7')}}" class="hidden-phone">
                                    Clasificación de gastos
                                </a>
                                <a href="{{url('admin-inquilino/configurar/paso7')}}" class="hidden-phone">
                                    <small>¿Como se distribuyen los gastos de tu condominio?</small>
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==8 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">8</span>
                                <a href="{{url('admin-inquilino/configurar/paso8')}}" class="hidden-phone">
                                    Ultimos detalles
                                </a>
                            </li>
                            <li role="tab" aria-selected="true" class="{{$paso==9 ? 'active':''}}" style="z-index: 6;">
                                <span class="label badge-inverse">9</span>
                                <a href="{{url('admin-inquilino/configurar/paso9')}}" class="hidden-phone">
                                    Finalizar
                                </a>
                            </li>
                        </ol>
                        <div class="well">
                            @yield('contenido2')
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    @if($paso-1>0)
                                        <a href="{{url('admin-inquilino/configurar/paso'.($paso-1))}}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> Paso Anterior</a>
                                    @endif
                                </div>
                                <div class="form-group col-md-2 col-md-offset-8">
                                    @if($paso<9)
                                        <button type="submit" class="btn btn-primary pull-right">Próximo Paso <i class="fa fa-long-arrow-right"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection
@section('javascript')
    {!!HTML::script("assets/plugins/bootstrap-wizard/js/bwizard.js")!!}
    {!!HTML::script("assets/js/form-wizards.demo.min.js")!!}
    <script>
        $(document).ready(function() {
            //FormWizard.init();
        });
    </script>
@endsection