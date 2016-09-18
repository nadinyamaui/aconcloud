@extends('layouts.'.$formato)
@section('reporte')
    <h3 style="text-align: center;">
        Aviso de Cobro
    </h3>
    @include('consultas.recibos._recibo')
@endsection
@section('css')
    {!!HTML::style('css/views/consultas/recibos.css')!!}
@endsection