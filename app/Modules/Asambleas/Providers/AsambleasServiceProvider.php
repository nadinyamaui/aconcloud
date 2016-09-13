<?php
namespace App\Modules\Asambleas\Providers;

use App;
use App\Modules\Asambleas\Asamblea;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Lang;
use View;
use App\Modules\Asambleas\Listeners\Models\AsambleaObserver;
use App\Models\App\User;

class AsambleasServiceProvider extends ServiceProvider
{
    public function boot(Dispatcher $dispatcher)
    {
        $this->registerObservers($dispatcher);
        $this->registerNamespaces();
    }

    protected function registerObservers($dispatcher)
    {
        Asamblea::observe(new AsambleaObserver($dispatcher));
    }

    /**
     * Register the Asambleas module service provider.
     *
     * @return void
     */
    public function register()
    {
        // This service provider is a convenient place to register your modules
        // services in the IoC container. If you wish, you may make additional
        // methods or service providers to keep the code more focused and granular.
        App::register(RouteServiceProvider::class);
        App::register(ConsoleServiceProvider::class);

        $this->registerMenuLinks();
    }

    protected function registerMenuLinks()
    {
        $data = View::getShared();

        $opciones = [];

        $opciones[] = [
            'ruta' => 'modulos/asambleas/asambleas/create',
            'etiqueta' => 'Convocar asamblea',
        ];

        $opciones[] = [
            'ruta' => 'modulos/asambleas/asambleas',
            'etiqueta' => 'Asambleas',
        ];

        $data['menu'][] = [
            'selector' => 'modulos/asambleas',
            'etiqueta' => 'Asambleas',
            'icon' => 'home',
            'opciones' => $opciones
        ];

        View::share('menu', $data['menu']);
    }

    /**
     * Register the Asambleas module resource namespaces.
     *
     * @return void
     */
    protected function registerNamespaces()
    {
        Lang::addNamespace('asambleas', realpath(__DIR__ . '/../Resources/Lang'));

        View::addNamespace('asambleas', realpath(__DIR__ . '/../Resources/Views'));
    }
}
