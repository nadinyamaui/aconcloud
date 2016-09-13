@extends('admin.usuarios.layout')
@section('contenido2')
    @if($usuario->id)
        @include('templates.panel-header', ['titulo'=>'Modificar el Usuario'])
    @else
        @include('templates.panel-header', ['titulo'=>'Crear un nuevo Usuario'])
    @endif
    <div class="panel-body">
        @include('templates.errores')
        {!!Form::model($usuario, ['url'=>'admin/usuarios'])!!}
        {!!Form::hidden('id')!!}
        <div class="row">
            {!!Form::simple('nombre', 4)!!}
            {!!Form::simple('apellido', 4)!!}
            {!!Form::simple('email', 4)!!}
        </div>
        <div class="row">
            @if($usuario->exists)
                {!!Form::simple('password', 6, 'password')!!}
                {!!Form::simple('password_confirmation', 6, 'password')!!}
            @else
                <div class="col-md-8">
                    <p>La contraseña por defecto es aconcloud, cuando se inicie sesión por primera vez se le pedirá
                        al usuario que cambie su clave</p>
                </div>
                {!!Form::hidden('password', 'aconcloud')!!}
                {!!Form::hidden('password_confirmation', 'aconcloud')!!}
            @endif
        </div>
        <div class="row">
            {!!Form::simple('ind_activo', 4)!!}
            {!!Form::simple('telefono_celular', 4)!!}
            {!!Form::simple('telefono_otro', 4)!!}
        </div>
        <div class="row">
            {!!Form::simple('ind_recibir_gastos_creados', 3)!!}
            {!!Form::simple('ind_recibir_gastos_modificados', 3)!!}
            {!!Form::simple('ind_recibir_ingresos_creados', 3)!!}
            {!!Form::simple('ind_recibir_ingresos_modificados', 3)!!}
        </div>
        <div class="row">
            {!!Form::simple('ind_autenticacion_en_dos_pasos', 3)!!}
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Roles del usuario</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Inquilino</th>
                        <th>Grupo</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="display: none;" id="layout-row">
                        <td>{!!Form::hidden('inquilino_user_id[]','')!!}{!!Form::simple2($rol,'inquilino_id[]')!!}</td>
                        <td>{!!Form::simple2($rol,'grupo_id[]')!!}</td>
                        <td class="text-center"><span class="btn btn-xs btn-primary glyphicon glyphicon-remove delete-rol"></span></td>
                    </tr>
                    @foreach($usuario->inquilinos as $inquilinoUser)
                        <tr>
                            <td>{!!Form::hidden('inquilino_user_id[]',$inquilinoUser->id)!!}{!!Form::simple2($inquilinoUser,'inquilino_id[]')!!}</td>
                            <td>{!!Form::simple2($inquilinoUser,'grupo_id[]')!!}</td>
                            <td class="text-center"><span class="btn btn-xs btn-primary glyphicon glyphicon-remove delete-rol"></span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary pull-right" id="add-new-rol">Agregar un rol</button>
            </div>
        </div>
        {!!Form::submitBt()!!}
        {!!Form::close()!!}
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/admin/usuarios/form.js')!!}
@endsection