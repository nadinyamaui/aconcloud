<?php

namespace App\Http\Middleware;

use Closure;

class VerificarTerminosAceptadosMiddleware
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
        if (auth()->check() && auth()->user()->terminos_aceptados == false && !$request->is('terminos-condiciones')) {
            return redirect('terminos-condiciones');
        }
        return $next($request);
    }
}
