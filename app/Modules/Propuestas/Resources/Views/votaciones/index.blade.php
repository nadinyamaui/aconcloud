@extends('layouts.master')
@section('contenido')
        <!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="#">Propuestas</a></li>
    <li><a href="{{url('modulos/propuestas/propuestas/'.$propuesta->id)}}">{{$propuesta->titulo}}</a></li>
    <li class="active">Votaciones</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">{{$propuesta->titulo}}
    <small>Aqui puedes ver un resumen de las votaciones hasta el momento</small>
</h1>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
    @include('templates.mensaje')
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-orange">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-users"></i></div>
                <div class="stats-title">Total de votantes</div>
                <div class="stats-number">{{$propuesta->total_votantes}}</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-red-darker">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-clock-o"></i></div>
                <div class="stats-title">Total de votos pendientes</div>
                <div class="stats-number">{{$propuesta->total_votantes_pendientes}}</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-green">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-check"></i></div>
                <div class="stats-title">Total de votos a favor</div>
                <div class="stats-number">{{$propuesta->total_votos_a_favor}}</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-red">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-times"></i></div>
                <div class="stats-title">Total de votos en contra</div>
                <div class="stats-number">{{$propuesta->total_votos_en_contra}}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-7">
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Votantes'])
                <div class="panel-body">
                    {!!HTML::tableAjax(\App\Modules\Propuestas\Votacion::class, $columnas_votacion_total, false, false, false, false, ["list"=>"modulos/propuestas/propuestas/".$propuesta->id.'/votaciones?solo_cerradas=true', 'url'=>''], false)!!}
                </div>
            </div>
        </div>
        <!-- end col-6 -->

        <!-- begin col-6 -->
        <div class="col-md-5">
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Votantes Pendientes'])
                <div class="panel-body">
                    {!!HTML::tableAjax(\App\Modules\Propuestas\Votacion::class, $columnas_votacion_pendientes, false, false, false, false, ["list"=>"modulos/propuestas/propuestas/".$propuesta->id.'/votaciones?solo_pendiente=true', 'url'=>''], false)!!}
                </div>
            </div>
        </div>
        <!-- end col-6 -->
    </div>
</div>
<!-- end row -->
@endsection