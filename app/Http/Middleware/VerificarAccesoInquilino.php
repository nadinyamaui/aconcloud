<?php namespace App\Http\Middleware;

use App\Models\App\Inquilino as InquilinoDB;
use Closure;

class VerificarAccesoInquilino
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
        $user = \Auth::user();
        if (is_object($user) && $user->tieneAcceso(InquilinoDB::$current) && $user->ind_activo) {
            return $next($request);
        } else {
            if (!is_object($user)) {
                return $next($request);
            }
        }
        \Auth::logout();
        if (!$user->ind_activo) {
            return redirect('auth/login')->with('error', 'Tu usuario ha sido desactivado');
        } else {
            return redirect('auth/login')->with('error', 'No tienes acceso para este inquilino');
        }
    }
}
