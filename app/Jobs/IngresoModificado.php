<?php namespace App\Jobs;

use App\Models\App\Inquilino;
use App\Models\App\User;
use App\Models\Inquilino\Cuenta;
use App\Models\Inquilino\Fondo;
use App\Models\Inquilino\MovimientosCuenta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IngresoModificado extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $ingreso;
    protected $usuario;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($ingreso, User $user)
    {
        parent::__construct();
        $this->ingreso = $ingreso;
        $this->usuario = User::find($user->id);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        Inquilino::setActivo($this->inquilino->host);
        $data['ingreso'] = MovimientosCuenta::findOrFail($this->ingreso);
        $data['responsable'] = $this->usuario->nombre;
        $data['inquilino'] = $this->inquilino;
        $data['fondos'] = Fondo::all();
        $data['cuentas'] = Cuenta::all();
        $usuarios = $this->inquilino->usuarios()->whereIndRecibirIngresosModificados(true)->get();
        $nombreInquilino = $this->inquilino->nombre;
        $asunto = 'Ingreso modificado en ' . $nombreInquilino;

        foreach ($usuarios as $usuario) {
            $data['nombre'] = $usuario->nombre_completo;
            $usuario->enviarCorreo('emails.ingresos.updated', $data, $asunto);
        }
    }
}
