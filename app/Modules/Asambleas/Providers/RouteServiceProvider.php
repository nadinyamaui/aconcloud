<?php
namespace App\Modules\Asambleas\Providers;

use Caffeinated\Modules\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your module's routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Modules\Asambleas\Http\Controllers';

    /**
     * Define your module's route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        //
    }

    /**
     * Define the routes for the module.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(
            ['namespace' => $this->namespace, 'prefix' => 'modulos/asambleas', 'middleware' => 'auth'],
            function ($router) {
                $router->get('asambleas/{id}/comenzar', 'AsambleasController@comenzar');
                $router->get('asambleas/{id}/terminada', 'AsambleasController@terminada');
                $router->resource('asambleas', 'AsambleasController');
                $router->post('asambleas/{asamblea_id}/asistentes/datatable', 'AsistentesController@datatable');
                $router->post('asambleas/{asamblea_id}/asistentes/estatus', 'AsistentesController@estatus');
            }
        );
    }
}
