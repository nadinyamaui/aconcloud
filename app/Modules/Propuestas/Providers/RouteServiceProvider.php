<?php
namespace App\Modules\Propuestas\Providers;

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
    protected $namespace = 'App\Modules\Propuestas\Http\Controllers';

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
            ['namespace' => $this->namespace, 'prefix' => 'modulos/propuestas', 'middleware' => 'auth'],
            function ($router) {
                $router->get('propuestas/{id}/activar-votacion', 'PropuestasController@activarVotacion');
                $router->get('propuestas/{id}/recordar-vecinos', 'PropuestasController@recordarVecinos');
                $router->get('propuestas/{id}/cerrar-votacion', 'PropuestasController@cerrarVotacion');

                $router->resource('propuestas', 'PropuestasController');

                $router->get('propuestas/{propuesta_id}/votaciones/votar', 'VotacionesController@votar');
                $router->post('propuestas/{propuesta_id}/votaciones/votar', 'VotacionesController@procesarVoto');
                $router->post('propuestas/{propuesta_id}/votaciones/datatable', 'VotacionesController@datatable');

                $router->resource('propuestas/{propuesta_id}/votaciones', 'VotacionesController');
            }
        );
    }
}
