@extends('layouts.master')
@section('contenido')
    <!-- begin page-header -->
    <h1 class="page-header">Recibos de tu condominio <small>Aqui puedes ver el listado de recibos generados en tu condominio</small></h1>
    <!-- end page-header -->
    <!-- begin vertical box -->
    <div class="vertical-box">
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column width-150">
            <!-- begin wrapper -->
            <div class="wrapper">
                <p><b>Tipo de viviendas</b></p>
                <ul class="nav nav-pills nav-stacked nav-sm">
                    <li class="{{!Input::has('tipo_vivienda_id') ? 'active':''}}">
                        <a href="{{url('consultas/recibos?corte_id='.Input::get('corte_id'))}}">
                            <i class="fa fa-fw m-r-5 fa-circle text-inverse"></i> Todos</a>
                    </li>
                    @foreach($tipos as $tipo)
                        <li class="{{Input::get('tipo_vivienda_id')==$tipo->id ? 'active':''}}">
                            <a href="{{url('consultas/recibos?tipo_vivienda_id='.$tipo->id."&corte_id=".Input::get('corte_id'))}}">
                                <i class="fa fa-fw m-r-5 fa-circle text-inverse"></i> {{$tipo->nombre}}</a>
                        </li>
                    @endforeach
                </ul>
                <p><b>Cortes</b></p>
                <ul class="nav nav-pills nav-stacked nav-sm m-b-0">
                    @foreach($cortes as $corte)
                        <li class="{{Input::get('corte_id')==$corte->id ? 'active':''}}">
                            <a href="{{url('consultas/recibos?corte_id='.$corte->id.(Input::has('tipo_vivienda_id') ?
                            ('&tipo_vivienda_id='.Input::get('tipo_vivienda_id')):''))}}">
                                <i class="fa fa-fw m-r-5 fa-circle text-inverse"></i> {{$corte->nombre_corto}}</a>
                        </li>
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
                        @include('templates.panel-header', ['titulo'=>'Listado de recibos'])
                        @include('templates.mensaje')
                        <div class="panel-body">
                            {!!HTML::tableAjax('App\Models\Inquilino\Recibo', $columns, false, false, false, true, "consultas/recibos")!!}
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