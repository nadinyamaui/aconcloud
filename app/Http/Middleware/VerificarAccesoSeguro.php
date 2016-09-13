<?php

namespace App\Http\Middleware;

use App\Models\App\Inquilino as InqulinoDB;
use Closure;

class VerificarAccesoSeguro
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
        $inquilinosSeguros = ['miranda.aconcloud.com.ve'];
        if(!$request->isSecure() && in_array(InqulinoDB::$current->host, $inquilinosSeguros) && env('APP_ENV') != "local"){
            return redirect()->secure($request->path());
        }
        return $next($request);
    }
}
