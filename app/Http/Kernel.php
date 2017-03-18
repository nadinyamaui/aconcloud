<?php namespace App\Http;

use App\Http\Middleware\Admin;
use App\Http\Middleware\DbTransaction;
use App\Http\Middleware\Inquilino;
use App\Http\Middleware\Junta;
use App\Http\Middleware\Propietario;
use App\Http\Middleware\VerificarAccesoInquilino;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\VerificarAccesoSeguro;
use App\Http\Middleware\VerificarTerminosAceptadosMiddleware;
use App\Http\Middleware\VerificarCambioContrasena;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        Inquilino::class,
        VerificarAccesoSeguro::class,
        VerificarAccesoInquilino::class,
        VerificarTerminosAceptadosMiddleware::class,
        VerificarCambioContrasena::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'                 => 'App\Http\Middleware\RedirectIfAuthenticated',
        'inquilino.configurado' => 'App\Http\Middleware\VerificarInquilinoConfigurado',
        'ingreso.configuracion' => 'App\Http\Middleware\VerificarIngresoConfiguracion',
        'permisos.admin'        => Admin::class,
        'permisos.junta'        => Junta::class,
        'permisos.propietario'  => Propietario::class,
    ];
}
