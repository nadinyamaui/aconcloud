<?php
namespace App\Modules\Comentarios\Providers;

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
    protected $namespace = 'App\Modules\Comentarios\Http\Controllers';

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
        $router->group(['namespace' => $this->namespace, 'prefix' => 'modulos/comentarios', 'middleware' => 'auth'],
            function ($router) {
                require(config('modules.path') . '/Comentarios/Http/routes.php');
            });
    }
}
