@extends('layouts.master')
@section('contenido')
    <!-- begin page-header -->
    <h1 class="page-header">Recibo {{$recibo->num_recibo}}</h1>
    <!-- end page-header -->
    <div class="invoice">
        <div class="invoice-company">
                    <span class="pull-right hidden-print">
                    <a href="{{url('consultas/recibos/descargar/'.$recibo->id.'?formato=pdf')}}" class="btn btn-sm btn-success m-b-10"><i class="fa fa-download m-r-5"></i> Descargar en pdf</a>
                    <a href="#" class="btn btn-sm btn-success m-b-10" onclick="window.print();"><i class="fa fa-print"></i></a>
                    </span>
            Aviso de Cobro
        </div>
        @include('consultas.recibos._recibo')
    </div>
@endsection
@section('css')
    {!!HTML::style('css/views/consultas/recibos.css')!!}
@endsection