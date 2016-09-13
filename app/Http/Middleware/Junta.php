<?php namespace App\Http\Middleware;

use App\Models\App\User;
use Closure;

class Junta extends Permisos
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
        if (User::esJunta(true)) {
            return $next($request);
        }

        return $this->denyAccess();
    }

}
