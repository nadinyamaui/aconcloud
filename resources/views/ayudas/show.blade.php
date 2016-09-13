@extends('layouts.master')
@section('contenido')
    <!-- Blog Post -->
    <!-- Title -->
    <h1 class="page-header">{{$ayuda->titulo}}</h1>

    <div class="panel panel-info">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <hr>
                    <p><span class="glyphicon glyphicon-user"></span> {{$ayuda->autor->nombre_completo}}</p>
                    <p><span class="glyphicon glyphicon-time"></span> Publicado el {{$ayuda->created_at->format('d/m/Y h:i A')}}</p>
                    <p><span class="glyphicon glyphicon-tag"></span> {{$ayuda->tipoAyuda->nombre}}</p>
                    <hr>
                    {!!$ayuda->contenido!!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{url('ayudas')}}" class="btn btn-primary "><i class="glyphicon glyphicon-arrow-left"></i> Volver</a>
                </div>
            </div>
        </div>
    </div>

@endsection