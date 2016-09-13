@extends('layouts.master')
@section('contenido')
        <!-- begin page-header -->
<h1 class="page-header">Propuestas vecinales en Aconcloud<small> {{$propuestas->count()}} resultados encontrados</small></h1>
<!-- end page-header -->

<div class="row">
    <div class="col-md-12">
        <div class="result-container">
            <form method="get">
                <div class="input-group m-b-20">
                    <input name="q" value="{{Input::get('q')}}" type="text" class="form-control input-white" placeholder="Buscar" />
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            <div class="panel panel-info">
                <div class="panel-body">
                    @include('templates.mensaje')
                    <div class="row same-height">
                        @foreach($propuestas as $propuesta)
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <h3>
                                    {!!link_to('modulos/propuestas/propuestas/'.$propuesta->id, $propuesta->titulo)!!}
                                </h3>
                                <p><span class="glyphicon glyphicon-user"></span> {{$propuesta->autor->nombre_completo}}</p>
                                <p><span class="glyphicon glyphicon-time"></span> Publicado el {{$propuesta->created_at->format('d/m/Y h:i A')}}</p>

                                <p><span class="glyphicon glyphicon-flag"></span> Fecha de cierre {{$propuesta->fecha_cierre->format('d/m/Y')}}</p>
                                <p><span class="label label-{{$propuesta->getEstatusColor()}}">{{$propuesta->estatus_display}}</span></p>

                                @if($propuesta->estatus == "cerrada")
                                    <p><span class="label label-{{$propuesta->getDecisionColor()}}">{{$propuesta->decision_display}}</span></p>
                                @endif

                                <div>
                                    <a class="btn btn-success" href="{{url('modulos/propuestas/propuestas/'.$propuesta->id)}}">Ver Más <span class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                                <br>
                                <div>
                                    @if($propuesta->puedeEditar())
                                        <a class="btn btn-xs btn-danger boton-eliminar" href="#"
                                           data-url="{{url('modulos/propuestas/propuestas/'.$propuesta->id)}}"
                                           data-reload="true"><i class="glyphicon glyphicon-trash"></i></a>

                                        <a class="btn btn-xs btn-primary" href="{{url('modulos/propuestas/propuestas/'.$propuesta->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
                                    @endif
                                </div>
                                <hr>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection