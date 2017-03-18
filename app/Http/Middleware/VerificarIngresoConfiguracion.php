<?php namespace App\Http\Middleware;

use App\Models\App\Inquilino as InquilinoDb;
use Closure;

class VerificarIngresoConfiguracion
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
        $inquilino = InquilinoDb::$current;
        if ($inquilino->ind_configurado) {
            return redirect('')->with('mensaje', 'Este condominio ya esta configurado');
        }

        return $next($request);
    }
}
