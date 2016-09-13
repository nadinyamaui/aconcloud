@extends('layouts.master')
@section('contenido')
    <!-- begin page-header -->
    <h1 class="page-header">Ingresos registrados <small>Aqui puedes ver el detalle de todos los ingresos de tu condominio</small></h1>
    <!-- end page-header -->
    <!-- begin vertical box -->
    <div class="vertical-box">
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column width-150">
            <!-- begin wrapper -->
            <div class="wrapper">
                <p><b>Filtros</b></p>
                <ul class="nav nav-pills nav-stacked nav-sm">
                    <li class="{{Input::get('mes')==$mesActual ? 'active':''}}"><a href="{{url('consultas/ingresos?mes='.$mesActual.'&ano='.$anoActual)}}"><i class="fa fa-inbox fa-fw m-r-5"></i> Este mes</a></li>
                </ul>
                <p><b>Clasificación</b></p>
                <ul class="nav nav-pills nav-stacked nav-sm m-b-0">
                    @foreach($clasificaciones as $clasificacion)
                        <li class="{{Input::get('clasificacion_id')==$clasificacion->id ? 'active':''}}"><a href="{{url('consultas/ingresos?clasificacion_id='.$clasificacion->id)}}"><i class="fa fa-fw m-r-5 fa-circle text-inverse"></i> {{$clasificacion->nombre}}</a></li>
                    @endforeach
                </ul>
            </div>
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column">
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        @include('templates.panel-header', ['titulo'=>'Listado de gastos'])
                        @include('templates.mensaje')
                        <div class="panel-body">
                            {!!HTML::tableAjax('App\Models\Inquilino\MovimientosCuenta', $columns, false, $es_junta, $es_junta, true, ["list"=>"consultas/ingresos","url"=>"registrar/ingresos"], false)!!}

                            @if(\App\Models\App\User::esJunta(true))
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="{{url('registrar/ingresos/create')}}" class="btn btn-primary "><i class="glyphicon glyphicon-plus-sign"></i> Registrar un ingreso</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
        </div>
        <!-- end vertical-box-column -->
    </div>
    <!-- end vertical box -->
@endsection