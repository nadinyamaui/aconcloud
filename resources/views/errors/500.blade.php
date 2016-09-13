@extends('errors.master')
@section('contenido')
    <!-- begin error -->
    <div class="error">
        <div class="error-code m-b-10">503 <i class="fa fa-error"></i></div>
        <div class="error-content">
            <div class="error-message">Esto es vergonzoso :(</div>
            <div class="error-desc m-b-20">
                Lo sentimos, algo malo ha pasado. Nuestro equipo lo solucionara pronto
            </div>
        </div>
    </div>
    <!-- end error -->
@endsection