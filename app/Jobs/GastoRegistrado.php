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

class GastoRegistrado extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $gasto;
    protected $usuario;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($gasto, User $user)
    {
        parent::__construct();
        $this->gasto = $gasto;
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
        $data['gasto'] = MovimientosCuenta::findOrFail($this->gasto);
        $data['responsable'] = $this->usuario->nombre;
        $data['inquilino'] = $this->inquilino;
        $data['fondos'] = Fondo::all();
        $data['cuentas'] = Cuenta::all();
        $usuarios = $this->inquilino->usuarios()->whereIndRecibirGastosCreados(true)->get();
        $nombreInquilino = $this->inquilino->nombre;
        $asunto = 'Nuevo gasto registrado en ' . $nombreInquilino;

        foreach ($usuarios as $usuario) {
            $data['nombre'] = $usuario->nombre_completo;

            $usuario->enviarCorreo('emails.gastos.created', $data, $asunto);
        }
    }
}
