<?php
namespace App\Modules\Mensajeria\Providers;

use App;
use App\Modules\Mensajeria\Listeners\Models\MensajeObserver;
use App\Modules\Mensajeria\Mensaje;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Lang;
use View;

class MensajeriaServiceProvider extends ServiceProvider
{
    public function boot(Dispatcher $dispatcher)
    {
        $this->registerObservers($dispatcher);
        $this->registerMenuLinks();
    }

    protected function registerObservers($dispatcher)
    {
        Mensaje::observe(new MensajeObserver($dispatcher));
    }

    /**
     * Register the Mensajeria module service provider.
     *
     * @return void
     */
    public function register()
    {
        // This service provider is a convenient place to register your modules
        // services in the IoC container. If you wish, you may make additional
        // methods or service providers to keep the code more focused and granular.
        App::register('App\Modules\Mensajeria\Providers\RouteServiceProvider');

        $this->registerNamespaces();
    }

    /**
     * Register the Mensajeria module resource namespaces.
     *
     * @return void
     */
    protected function registerNamespaces()
    {
        Lang::addNamespace('mensajeria', realpath(__DIR__ . '/../Resources/Lang'));

        View::addNamespace('mensajeria', realpath(__DIR__ . '/../Resources/Views'));
    }

    protected function registerMenuLinks()
    {
        $data = View::getShared();
        $data['menu'][] = [
            'selector' => 'modulos/mensajeria/mensajes',
            'etiqueta' => 'Mensajeria',
            'icon'     => 'inbox',
            'opciones' => [
                [
                    'ruta'     => 'modulos/mensajeria/mensajes/create',
                    'etiqueta' => 'Nuevo Mensaje',
                ],
                [
                    'ruta'     => 'modulos/mensajeria/mensajes',
                    'etiqueta' => 'Bandeja de entrada',
                ],
            ],
        ];
        View::share('menu', $data['menu']);
    }
}
