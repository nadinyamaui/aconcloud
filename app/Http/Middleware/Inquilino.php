<?php namespace App\Http\Middleware;

use App\Models\App\Inquilino as InquilinoDB;
use App\Models\Inquilino\Alarma;
use Auth;
use Carbon\Carbon;
use Closure;
use View;

class Inquilino
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
        $inquilino = InquilinoDB::setActivo($request->getHost());
        View::share('inquilinoActivo', $inquilino);
        if (Auth::check()) {
            $user = Auth::user();
            $alarmasVencidas = Alarma::filtrarPorUsuario($user->id)
                ->where('alarmas.fecha_vencimiento', '<=', Carbon::now())
                ->where('alarmas.ind_atendida', false)->get();

            $cantAlarmasVencidas = $alarmasVencidas->count();

            View::share('cantAlarmasVencidas', $cantAlarmasVencidas);
            View::share('alarmasVencidas', $alarmasVencidas);
        }

        return $next($request);
    }

}
