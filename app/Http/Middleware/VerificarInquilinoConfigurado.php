<?php namespace App\Http\Middleware;

use App\Models\App\Inquilino as InquilinoDb;
use Closure;

class VerificarInquilinoConfigurado
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
            return $next($request);
        }

        return redirect('admin-inquilino/configurar/paso1')->with('mensaje', 'Debes configurar tu condominio primero');
    }
}
