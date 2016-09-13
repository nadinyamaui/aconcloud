<?php

namespace App\Modules\Propuestas\Http\Middleware;

use App\Modules\Propuestas\Propuesta;
use Closure;

class SoloEditaPropuestasAbiertas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $propuesta = Propuesta::findOrFail($request->route('propuestas'));
        if($propuesta->puedeEditar()){
            return $next($request);
        }

        return redirect('modulos/propuestas/propuestas')->with('mensaje',
            'No se puede modificar esta propuesta porque esta en proceso de votación o esta cerrada');
    }
}
