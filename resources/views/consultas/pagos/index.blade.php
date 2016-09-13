@extends('layouts.master')
@section('contenido')
    <!-- begin page-header -->
    <h1 class="page-header">Pagos registrados <small>Aqui puedes ver todos los pagos registrados en tu condominio</small></h1>
    <!-- end page-header -->
    <!-- begin vertical box -->
    <div class="vertical-box">
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column width-150">
            <!-- begin wrapper -->
            <div class="wrapper">
                <p><b>Filtros</b></p>
                <ul class="nav nav-pills nav-stacked nav-sm">
                    <li class="{{Input::get('estatus')=='PEN' ? 'active':''}}"><a href="{{url('consultas/pagos?estatus=PEN')}}"><i class="fa fa-clock-o fa-fw m-r-5"></i> Pendientes</a></li>
                    <li class="{{Input::get('estatus')=='PRO' ? 'active':''}}"><a href="{{url('consultas/pagos?estatus=PRO')}}"><i class="fa fa-check fa-fw m-r-5"></i> Procesados</a></li>
                    <li class="{{Input::get('estatus')=='DEV' ? 'active':''}}"><a href="{{url('consultas/pagos?estatus=DEV')}}"><i class="fa fa-undo fa-fw m-r-5"></i> Devueltos</a></li>
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
                        @include('templates.panel-header', ['titulo'=>'Listado de pagos'])
                        @include('templates.mensaje')
                        <div class="panel-body">
                            {!!HTML::tableAjax('App\Models\Inquilino\Pago', $columns, false, true, true, true, ["url"=>"recibos/pagos", "list"=>"consultas/pagos"])!!}
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="{{url('recibos/pagos/create')}}" class="btn btn-primary "><i class="glyphicon glyphicon-plus-sign"></i> Registrar un pago</a>
                                </div>
                            </div>
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