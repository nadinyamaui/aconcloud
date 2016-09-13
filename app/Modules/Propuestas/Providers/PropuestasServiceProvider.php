<?php
namespace App\Modules\Propuestas\Providers;

use App;
use App\Modules\Propuestas\Listeners\Models\PropuestaObserver;
use App\Modules\Propuestas\Listeners\Models\VotacionObserver;
use App\Modules\Propuestas\Propuesta;
use App\Modules\Propuestas\Votacion;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Lang;
use View;
use App\Models\App\User;

class PropuestasServiceProvider extends ServiceProvider
{
    public function boot(Dispatcher $dispatcher)
    {
        $this->registerObservers($dispatcher);
        $this->registerMenuLinks();
    }

    protected function registerObservers($dispatcher)
    {
        Propuesta::observe(new PropuestaObserver($dispatcher));
        Votacion::observe(new VotacionObserver($dispatcher));
    }

    /**
     * Register the Propuestas module service provider.
     *
     * @return void
     */
    public function register()
    {
        // This service provider is a convenient place to register your modules
        // services in the IoC container. If you wish, you may make additional
        // methods or service providers to keep the code more focused and granular.
        App::register(RouteServiceProvider::class);

        $this->registerNamespaces();
    }

    /**
     * Register the Propuestas module resource namespaces.
     *
     * @return void
     */
    protected function registerNamespaces()
    {
        Lang::addNamespace('propuestas', realpath(__DIR__ . '/../Resources/Lang'));

        View::addNamespace('propuestas', realpath(__DIR__ . '/../Resources/Views'));
    }

    protected function registerMenuLinks()
    {
        $data = View::getShared();
        $opciones = [];

        $opciones[] = [
            'ruta'     => 'modulos/propuestas/propuestas/create',
            'etiqueta' => 'Nueva Propuesta',
        ];

        $opciones[] = [
            'ruta'     => 'modulos/propuestas/propuestas',
            'etiqueta' => 'Propuestas',
        ];

        $data['menu'][] = [
            'selector' => 'modulos/propuestas',
            'etiqueta' => 'Propuestas',
            'icon'     => 'comment-o',
            'opciones' => $opciones,
        ];
        View::share('menu', $data['menu']);
    }
}
