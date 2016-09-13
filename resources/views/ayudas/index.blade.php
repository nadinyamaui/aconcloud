@extends('layouts.master')
@section('contenido')
    <!-- begin page-header -->
    <h1 class="page-header">Ayudas/ Tutoriales de Aconcloud<small> {{$ayudas->count()}} resultados encontrados</small></h1>
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
                            @foreach($ayudas as $ayuda)
                                <div class="col-xs-12 col-md-6 col-lg-4">
                                    <h3>
                                        {!!link_to('ayudas/'.$ayuda->id, $ayuda->titulo)!!}
                                    </h3>
                                    <p><span class="glyphicon glyphicon-user"></span> {{$ayuda->autor->nombre_completo}}</p>
                                    <p><span class="glyphicon glyphicon-time"></span> Publicado el {{$ayuda->created_at->format('d/m/Y h:i A')}}</p>
                                    <p><span class="glyphicon glyphicon-tag"></span> {{$ayuda->tipoAyuda->nombre}}</p>
                                    <p>{{$ayuda->descripcion}}</p>
                                    <div>
                                        <a class="btn btn-primary" href="{{url('ayudas/'.$ayuda->id)}}">Ver Más <span class="glyphicon glyphicon-chevron-right"></span></a>
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection