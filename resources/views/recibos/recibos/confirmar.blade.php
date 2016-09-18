@extends('layouts.master')
@section('contenido')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="#">Recibos</a></li>
        <li><a href="#">Generación</a></li>
        <li class="active">Confirmar Recibos</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Generación de recibos <small>Revisa que todo este bien</small></h1>
    <!-- end page-header -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-warning">
                @include('templates.panel-header', ['titulo'=>'Generación de recibos'])
                <div class="panel-body">
                    @include('templates.errores')
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>¡Ten cuidado!</strong> Revisa que los recibos generados esten correctos, una vez confirmada la operación no hay vuelta atras.
                    </div>
                    <fieldset>
                        <legend>Recibos generados</legend>
                        {!!HTML::customTable($recibos, \App\Models\Inquilino\Recibo::class, $columnas)!!}
                        {!!Form::open(['url' => 'recibos/recibos/confirmar'])!!}
                        {!!Form::hidden('id', $corte->id)!!}
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-check"></i> Todo esta bien, generar recibos</button>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </fieldset>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
@endsection