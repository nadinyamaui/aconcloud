<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Cerrar</span>
            </button>
            <h4 class="modal-title">Link de acceso para el registro de usuarios</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="note note-info">
                        <p>Copia este link y enviaselo por correo a todos los propietarios para que puedan ingresar y
                            registrarse</p>

                        <p>{{url('auth/registro/'.$inquilino->token_acceso.'/'.$inquilino->id)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>