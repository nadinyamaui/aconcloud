@extends('layouts.'.$formato)
@section('titulo')
    <p style="text-align: center;">
        Aviso de Cobro
    </p>
@endsection
@section('reporte')
    @include('consultas.recibos._recibo')
@endsection
@section('css')
    {!!HTML::style('css/views/consultas/recibos.css')!!}
@endsection