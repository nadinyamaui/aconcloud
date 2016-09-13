<?php

namespace App\Http\Middleware;

use Closure;

class VerificarCambioContrasena
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
        if(auth()->check() && auth()->user()->ind_cambiar_password && !$request->is('auth/nuevacontrasena') && !$request->is('terminos-condiciones')){
            return redirect('auth/nuevacontrasena');
        }
        return $next($request);
    }
}
