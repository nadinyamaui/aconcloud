<?php

namespace App\Modules\Propuestas\Http\Middleware;

use App\Models\App\User;
use App\Modules\Propuestas\Propuesta;
use Closure;

class VerificarAccesoPropuesta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $propuesta = Propuesta::findOrNew($request->route('propuestas'));
        if (User::esJunta(true) && $propuesta->estaAutorizado()) {
            return $next($request);
        }

        return redirect('modulos/propuestas/propuestas')->with(
            'error',
            'No tienes permiso para modificar o crear propuestas'
        );
    }
}
