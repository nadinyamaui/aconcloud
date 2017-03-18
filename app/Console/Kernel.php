<?php

namespace App\Console;

use App\Console\Commands\AppMigrate;
use App\Console\Commands\DatesUpgrade;
use App\Console\Commands\GenerarMovimientosCuentaAutomaticos;
use App\Console\Commands\RetryFailedSMS;
use App\Console\Commands\VerificarRecibosVencidos;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        VerificarRecibosVencidos::class,
        GenerarMovimientosCuentaAutomaticos::class,
        AppMigrate::class,
        DatesUpgrade::class,
        RetryFailedSMS::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('recibos:verificar-vencidos')->everyThirtyMinutes();
        $schedule->command('clasificaciones:generar-automaticos')->dailyAt('08:00');

        $prefix = Carbon::now()->format('Y/m/d/');
        $schedule->command('backup:run --only-db --prefix="db/' . $prefix . '"')->hourly();
        $schedule->command('backup:run --prefix="files/'.$prefix.'"')->dailyAt('23:00');
        $schedule->command('backup:clean')->daily();

        //Ejecutamos el comando que verifica que asambleas acaban de comenzar, se ejecuta cada minuto.
        $schedule->command('asambleas:enviar_notificacion_inicio')->everyMinute();

        //Ejecutamos el comando que verifica que asambleas comienzan en 30 minutos, se ejecuta cada minuto.
        $schedule->command('asambleas:enviar_notificacion_preparacion')->everyMinute();

        //Ejecutamos el comando que verifica que asambleas hay en el dia, se ejecuta todos los dias a las 8 am.
        $schedule->command('asambleas:enviar_notificacion_matutina')->dailyAt('08:00');
    }
}
