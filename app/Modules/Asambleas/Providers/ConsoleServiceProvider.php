<?php

namespace App\Modules\Asambleas\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Modules\Asambleas\Console\Commands\EnviarNotificacionInicioAsamblea;
use App\Modules\Asambleas\Console\Commands\EnviarNotificacionMatutina;
use App\Modules\Asambleas\Console\Commands\EnviarNotificacionPreparacion;

class ConsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands(EnviarNotificacionInicioAsamblea::class);
        $this->commands(EnviarNotificacionPreparacion::class);

        $this->commands(EnviarNotificacionMatutina::class);
    }
}