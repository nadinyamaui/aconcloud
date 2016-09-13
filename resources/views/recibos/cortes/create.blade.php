@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Recibos</a></li>
        <li><a href="#">Cortes</a></li>
        <li class="active">Generar Corte</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Generar corte de recibos <small>Aqui puedes generar el corte de recibos mensuales</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                @include('templates.panel-header', ['titulo'=>'Generar corte mensual de recibos'])
                <div class="panel-body">
                    @include('templates.mensaje')
                    @if($hayPendiente)
                        {!!Form::open(['url'=>'recibos/cortes'])!!}
                        <div class="note note-info">
                            <h4>Al hacer click en Generar Corte se generará el corte de recibo correspondiente al mes de <b>@lang('meses.'.$carbon->month)</b> del año <b>{{$carbon->year}}</b></h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary "><i class="fa fa-scissors"></i> Generar corte</button>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    @else
                        <div class="note note-info">
                            <h4>Aun no hay corte de recibos pendientes por generar, si quieres ver el corte de este mes puedes verlo en {{link_to('recibos/cortes/este-mes','Ver corte de este mes')}}</h4>
                        </div>
                    @endif
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection