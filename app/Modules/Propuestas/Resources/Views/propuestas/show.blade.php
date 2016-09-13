@extends('layouts.master')
@section('contenido')
        <!-- Title -->
<h1 class="page-header">{{$propuesta->titulo}}</h1>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
            @include('templates.panel-header', ['titulo'=>'Detalle de la propuesta'])
            @include('templates.mensaje')
            <div class="panel-body" id="panel-propuestas-show">
                <div class="row">
                    <div class="col-lg-12">
                        @if($propuesta->puedeVotar())
                            <a href="{{url('modulos/propuestas/propuestas/'.$propuesta->id.'/votaciones/votar')}}"
                               class="btn btn-danger "><i class="fa fa-paperclip"></i> Votar</a>
                        @endif

                        @if($propuesta->puedeVerVotacion())
                            <a href="{{url('modulos/propuestas/propuestas/'.$propuesta->id.'/votaciones')}}"
                               class="btn btn-warning "><i class="fa fa-certificate"></i> Votaciones</a>
                        @endif

                        @if($propuesta->puedeActivarVotacion())
                            <a href="{{url('modulos/propuestas/propuestas/'.$propuesta->id.'/activar-votacion')}}"
                               class="btn btn-warning "><i class="fa fa-thumbs-up"></i> Activar proceso de votación</a>
                        @endif

                        @if($propuesta->puedeNotificarVecinos())
                            <a href="{{url('modulos/propuestas/propuestas/'.$propuesta->id.'/recordar-vecinos')}}"
                               class="btn btn-warning"><i class="fa fa-envelope"></i> Recordar a los vecinos que aun no han votado</a>
                        @endif

                        @if($propuesta->puedeCerrarVotacion())
                            <a href="{{url('modulos/propuestas/propuestas/'.$propuesta->id.'/cerrar-votacion')}}"
                               class="btn btn-danger"><i class="fa fa-times"></i> Cerrar Proceso</a>
                        @endif

                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{url('modulos/propuestas/propuestas')}}" class="btn btn-primary "><i class="glyphicon glyphicon-arrow-left"></i> Volver</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <p><span class="glyphicon glyphicon-user"></span> {{$propuesta->autor->nombre_completo}}</p>
                        <p><span class="glyphicon glyphicon-time"></span> Publicado el {{$propuesta->created_at->format('d/m/Y h:i A')}}</p>

                        <p><span class="glyphicon glyphicon-flag"></span> Fecha de cierre {{$propuesta->fecha_cierre->format('d/m/Y')}}</p>
                        <hr>
                        {!!$propuesta->propuesta!!}
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{url('modulos/propuestas/propuestas')}}" class="btn btn-primary "><i class="glyphicon glyphicon-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @include('chat.panel', ['titulo'=>'Debate sobre la propuesta', 'item'=>$propuesta])
    </div>
</div>
@endsection