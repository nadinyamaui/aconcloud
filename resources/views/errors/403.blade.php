@extends('errors.master')
@section('contenido')
    <!-- begin error -->
    <div class="error">
        <div class="error-code m-b-10">403 <i class="fa fa-warning"></i></div>
        <div class="error-content">
            <div class="error-message">No tienes permiso para acceder a esta sección</div>
            <div class="error-desc m-b-20">
                <div>
                    {!!HTML::link('','Volver al inicio',['class'=>'btn btn-success'])!!}
                </div>
            </div>
        </div>
    </div>
    <!-- end error -->
@endsection