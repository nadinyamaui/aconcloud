@if(Session::has('mensaje'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{Session::pull('mensaje')}}
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{Session::pull('error')}}
    </div>
@endif
@include('templates.errores')