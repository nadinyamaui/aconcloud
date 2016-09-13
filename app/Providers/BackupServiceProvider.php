<?php

namespace App\Providers;

use App\Console\Commands\BackupCommand;
use Spatie\Backup\Commands\CleanCommand;

class BackupServiceProvider extends \Spatie\Backup\BackupServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app['command.backup:run'] = $this->app->share(
            function ($app) {
                return new BackupCommand();
            }
        );

        $this->app['command.backup:clean'] = $this->app->share(
            function ($app) {
                return new CleanCommand();
            }
        );

        $this->commands(['command.backup:run', 'command.backup:clean']);
    }
}
