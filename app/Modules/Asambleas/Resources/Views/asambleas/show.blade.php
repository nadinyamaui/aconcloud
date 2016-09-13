@extends('layouts.master')
@section('contenido')
        <!-- Blog Post -->
<!-- Title -->
<h1 class="page-header">{{$asamblea->titulo}}</h1>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
            @include('templates.panel-header', ['titulo'=>'Detalles de la asamblea'])
            @include('templates.mensaje')
            <div class="panel-body" id="panel-asambleas-show">
                @if($asamblea->estatus!="en_curso")
                    @if($asamblea->estaRetrasada())
                        <div class="note note-danger">
                            <h4>Importante</h4>
                            <p>
                                Esta asamblea est&aacute; retrasada, aun no has creado el evento en youtube<br>
                            </p>
                            <p>
                                {!! link_to('https://www.youtube.com/my_live_events?action_create_live_event=1', 'Ir a crear el evento ahora') !!}
                            </p>
                            <p>
                                {!! link_to('modulos/asambleas/asambleas/'.$asamblea->id.'/edit', "&iquest;Ya tienes el link?. Haz clic aqu&iacute;") !!}
                            </p>
                        </div>
                    @endif
                    @if($asamblea->puedeEnCurso())
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="{{url('modulos/asambleas/asambleas/'.$asamblea->id.'/comenzar')}}" class="btn btn-warning "><i
                                            class="fa fa-check"></i> Comenzar Asamblea</a>
                            </div>
                        </div>
                        <br>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{url('modulos/asambleas/asambleas')}}" class="btn btn-primary "><i
                                        class="glyphicon glyphicon-arrow-left"></i> Volver</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <p><span class="glyphicon glyphicon-user"></span> {{$asamblea->autor->nombre_completo}}</p>

                            <p><span class="glyphicon glyphicon-time"></span> Convocada
                                el {{$asamblea->created_at->format('d/m/Y h:i A')}}</p>

                            <p><span class="glyphicon glyphicon-time"></span> Pautada para
                                el {{$asamblea->fecha->format('d/m/Y')}} a las {{ $asamblea->hora_inicio}} hasta
                                las {{ $asamblea->hora_fin}}  </p>
                            <hr>
                            <div>
                                <p>Durante esta asamblea se discutiran las siguientes propuestas:</p>
                                <ul>
                                    @foreach($propuestas as $propuesta)
                                        <li>{!! link_to('modulos/propuestas/propuestas/'.$propuesta->id, $propuesta->titulo) !!} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if($asamblea->youtube_embed_link != "")
                    <div class="iframe-wrapper">
                        <iframe width="420" height="315" frameborder="0" allowfullscreen
                                src="{{$asamblea->youtube_embed_link}}">
                        </iframe>
                    </div>
                @endif
                <br>

                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{url('modulos/asambleas/asambleas')}}" class="btn btn-primary "><i
                                    class="glyphicon glyphicon-arrow-left"></i> Volver</a>

                        @if($asamblea->puedeTerminar())
                            <a href="{{url('modulos/asambleas/asambleas/'.$asamblea->id.'/terminada')}}" class="btn btn-danger "><i
                                        class="fa fa-check"></i> Asamblea terminada</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        @include('chat.panel', ['titulo'=>'Chat de la asamblea', 'item'=>$asamblea])
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
            @include('templates.panel-header', ['titulo'=>'Asistentes a la asamblea'])
            <div class="panel-body" id="panel-asambleas-show">
                {!!HTML::tableAjax(\App\Modules\Asambleas\Asistente::class, $asistentesColums, false, false, false, false, ['list'=>'modulos/asambleas/asambleas/'.$asamblea->id.'/asistentes', 'url'=>''])!!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-inverse">
            @include('templates.panel-header', ['titulo'=>'Estadisticas de la asamblea'])
            <div class="panel-body" id="panel-asambleas-show">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget widget-stats bg-green">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-thumbs-up fa-fw"></i></div>
                            <div class="stats-title">Total de asistentes</div>
                            <div class="stats-number">{{$asamblea->total_asistentes}}</div>
                        </div>


                        <div class="widget widget-stats bg-red-darker">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-thumbs-down fa-fw"></i></div>
                            <div class="stats-title">Total de no asistentes</div>
                            <div class="stats-number">{{$asamblea->total_no_asistentes}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script>
        var asamblea_id = '{{$asamblea->id}}';
    </script>
    <script src="{{url('js/modulos/asambleas/asamblea.js')}}"></script>
@endsection