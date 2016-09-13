@extends('layouts.master')
@section('contenido')
    @if($corte->exists)
        {!!Form::hidden('id', $corte->id, ['id'=>'id'])!!}
    @else
        {!!Form::hidden('mes', $corte->mes, ['id'=>'mes'])!!}
        {!!Form::hidden('ano', $corte->ano, ['id'=>'ano'])!!}
    @endif
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:">Recibos</a></li>
        <li><a href="javascript:">Corte de recibos</a></li>
        <li class="active">Detalle</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">{{$corte->nombre}} <small>Aqui se muestra un detalle de como van los gastos e ingresos</small></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
    @include('templates.mensaje')
    <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-green">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
                <div class="stats-title">Ingresos</div>
                <div class="stats-number">{{$corte->getValueAt('ingresos')}} Bs.</div>
                <div class="stats-link">
                    <a href="{{url('consultas/ingresos?mes='.$corte->mes.'&ano='.$corte->ano)}}">Ver mas <i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-shopping-cart fa-fw"></i></div>
                <div class="stats-title">Gastos Comunes</div>
                <div class="stats-number">{{$corte->getValueAt('gastos_comunes')}} Bs.</div>
                <div class="stats-link">
                    <a href="{{url('consultas/gastos?mes='.$corte->mes.'&ano='.$corte->ano.'&ind_gasto_no_comun=0')}}">Ver mas <i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-purple">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-thumbs-o-down fa-fw"></i></div>
                <div class="stats-title">Gastos no comunes</div>
                <div class="stats-number">{{$corte->getValueAt('gastos_no_comunes')}} Bs.</div>
                <div class="stats-link">
                    <a href="{{url('consultas/gastos?mes='.$corte->mes.'&ano='.$corte->ano.'&ind_gasto_no_comun=1')}}">Ver mas <i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-black">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-bank fa-fw"></i></div>
                <div class="stats-title">Fondos de reserva</div>
                <div class="stats-number">{{$corte->getValueAt('total_fondos')}} Bs.</div>
            </div>
        </div>
        <!-- end col-3 -->
    </div>
    <!-- end row -->
    @if($corte->estatus=="ACT")
        <div class="row">
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-blue">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-bar-chart fa-fw"></i></div>
                    <div class="stats-title">Total recibos</div>
                    <div class="stats-number">{{$corte->getValueAt('total_recibos')}}</div>
                    <div class="stats-link">
                        <a href="{{url('consultas/recibos?corte_id='.$corte->id)}}">Ver mas <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-red">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-ambulance fa-fw"></i></div>
                    <div class="stats-title">Total recibos no pagados</div>
                    <div class="stats-number">{{$corte->getValueAt('total_recibos_no_pagados')}}</div>
                    <div class="stats-link">
                        <a href="{{url('consultas/recibos?corte_id='.$corte->id.'&estatus[]=GEN&estatus[]=VEN')}}">Ver mas <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-green">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-cc-visa fa-fw"></i></div>
                    <div class="stats-title">Total recibos pagados</div>
                    <div class="stats-number">{{$corte->getValueAt('total_recibos_pagados')}}</div>
                    <div class="stats-link">
                        <a href="{{url('consultas/recibos?corte_id='.$corte->id.'&estatus[]=PAG')}}">Ver mas <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-purple">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-bank fa-fw"></i></div>
                    <div class="stats-title">% de recaudación</div>
                    <div class="stats-number">{{$corte->getValueAt('porcentaje_recaudacion')}} %</div>
                </div>
            </div>
            <!-- end col-3 -->
        </div>
        <div class="row">
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-blue">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-money fa-fw"></i></div>
                    <div class="stats-title">Monto Total</div>
                    <div class="stats-number">{{$corte->getValueAt('monto_total_recibos')}} Bs.</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-red">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-user-md fa-fw"></i></div>
                    <div class="stats-title">Monto pendiente por pagar</div>
                    <div class="stats-number">{{$corte->getValueAt('monto_total_recibos_no_pagados')}} Bs.</div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-green">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-paypal fa-fw"></i></div>
                    <div class="stats-title">Monto pagado</div>
                    <div class="stats-number">{{$corte->getValueAt('monto_total_recibos_pagados')}} Bs.</div>
                </div>
            </div>
            <!-- end col-3 -->
        </div>
    @endif
    <div class="row">
        @if($corte->puedeGenerarRecibos())
            <div class="col-md-6">
                <div class="panel panel-warning">
                    @include('templates.panel-header', ['titulo'=>'Confirmar Corte de recibo'])
                    <div class="panel-body">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>¡Ten cuidado!</strong> Al generar los recibos de este periodo no podras agregar, modificar o eliminar gastos o ingresos.
                            Asegurate de haber terminado de registrar todo para poder continuar
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="{{url("recibos/recibos/confirmar/".$corte->id)}}" class="btn btn-warning "><i class="glyphicon glyphicon-check"></i> Si, he terminado todo generar recibos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    <!-- begin col-6 -->
        <div class="col-md-6">
            <div class="panel panel-inverse" data-sortable-id="morris-chart-3">
                @include('templates.panel-header', ['titulo'=>'Corte por tipo de vivienda'])
                <div class="panel-body">
                    <p class="lead text-justify">
                        Aqui puedes ver un detalle de cuanto pagará cada tipo de vivienda
                        con los gastos e ingresos que ha tenido tu condominio en el periodo seleccionado
                    </p>
                    <div id="grafico-tipo-vivienda" class="height-sm"></div>
                </div>
            </div>
        </div>
        <!-- end col-6 -->
        @if($corte->puedeVerRecibos())
        <!-- begin col-6 -->
            <div class="col-md-6">
                <div class="panel panel-inverse" data-sortable-id="morris-chart-3">
                    @include('templates.panel-header', ['titulo'=>'Recibos de este corte'])
                    <div class="panel-body">
                        {!!HTML::tableAjax('App\Models\Inquilino\Recibo', $columnas_recibo, false, false, false, true, ["list"=>"consultas/recibos?corte_id=".$corte->id,"url"=>"consultas/recibos"], false)!!}
                    </div>
                </div>
            </div>
            <!-- end col-6 -->
        @endif
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/recibos/corte.js')!!}
@endsection