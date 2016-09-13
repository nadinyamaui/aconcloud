<?php
namespace App\Modules\Comentarios\Providers;

use App;
use App\Modules\Comentarios\Comentario;
use App\Modules\Comentarios\Listeners\Models\ComentarioObserver;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Lang;
use View;

class ComentariosServiceProvider extends ServiceProvider
{
    public function boot(Dispatcher $dispatcher)
    {
        $this->registerObservers($dispatcher);
    }

    protected function registerObservers($dispatcher)
    {
        Comentario::observe(new ComentarioObserver($dispatcher));
    }

    /**
     * Register the Comentarios module service provider.
     *
     * @return void
     */
    public function register()
    {
        // This service provider is a convenient place to register your modules
        // services in the IoC container. If you wish, you may make additional
        // methods or service providers to keep the code more focused and granular.
        App::register('App\Modules\Comentarios\Providers\RouteServiceProvider');
        App::register('App\Modules\Comentarios\Providers\EventServiceProvider');

        $this->registerNamespaces();
    }

    /**
     * Register the Comentarios module resource namespaces.
     *
     * @return void
     */
    protected function registerNamespaces()
    {
        Lang::addNamespace('comentarios', realpath(__DIR__ . '/../Resources/Lang'));

        View::addNamespace('comentarios', realpath(__DIR__ . '/../Resources/Views'));
    }
}
