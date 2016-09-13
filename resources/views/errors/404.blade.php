@extends('errors.master')
@section('contenido')
    <!-- begin error -->
    <div class="error">
        <div class="error-code m-b-10">404 <i class="fa fa-error"></i></div>
        <div class="error-content">
            <div class="error-message">No lo pudimos encontrar</div>
            <div class="error-desc m-b-20">
                <div class="error-desc m-b-20">
                    La página que buscas no existe. <br />
                    ¿Por qué no vuelves al inicio y buscas lo que necesitas?
                </div>
                <div>
                    {!!HTML::link('','Volver al inicio',['class'=>'btn btn-success'])!!}
                </div>
            </div>
        </div>
    </div>
    <!-- end error -->
@endsection