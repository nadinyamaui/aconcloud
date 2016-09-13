@extends('layouts.master')
@section('contenido')
        <!-- begin page-header -->
<h1 class="page-header">Asambleas vecinales en Aconcloud<small> {{$asambleas->count()}} resultados encontrados</small></h1>
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
                    <div class="row same-height">
                        @foreach($asambleas as $asamblea)
                            <div class="col-xs-12 col-md-6 col-lg-4">
                                <h3>
                                    {!!link_to('modulos/asambleas/asambleas/'.$asamblea->id, $asamblea->titulo)!!}
                                </h3>
                                <p><span class="glyphicon glyphicon-user"></span> {{$asamblea->autor->nombre_completo}}</p>
                                <p><span class="glyphicon glyphicon-time"></span> Convocada el {{$asamblea->created_at->format('d/m/Y h:i A')}}</p>

                                <p><span class="glyphicon glyphicon-time"></span> Pautada para
                                    el {{$asamblea->fecha->format('d/m/Y')}} a las {{ $asamblea->hora_inicio}} hasta
                                    las {{ $asamblea->hora_fin}}  </p>
                                <p><span class="label label-{{$asamblea->getEstatusColor()}}">{{$asamblea->estatus_display}}</span></p>
                                <div>
                                    <a class="btn btn-success"
                                       href="{{url('modulos/asambleas/asambleas/'.$asamblea->id)}}">Ver Más <span
                                                class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                                <br>
                                <div>
                                    @if($asamblea->estaAutorizado())

                                        @if($asamblea->puedeEliminar())
                                            <a class="btn btn-xs btn-danger boton-eliminar" href="#"
                                               data-reload="true"
                                               data-url="{{url('modulos/asambleas/asambleas/'.$asamblea->id)}}"><i
                                                        class="glyphicon glyphicon-trash"></i></a>
                                        @endif

                                        @if($asamblea->puedeEditar())
                                            <a class="btn btn-xs btn-primary"
                                               href="{{url('modulos/asambleas/asambleas/'.$asamblea->id.'/edit')}}"><i
                                                        class="glyphicon glyphicon-pencil"></i></a>
                                        @endif
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