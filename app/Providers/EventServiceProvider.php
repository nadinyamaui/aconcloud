<?php namespace App\Providers;

use App\Events\CargarPanelesAdicionales;
use App\Listeners\CargarPanelArchivos;
use App\Listeners\ChatListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CargarPanelesAdicionales::class => [
            CargarPanelArchivos::class,
        ],
    ];

    protected $subscribe = [
        ChatListener::class,
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }

}
