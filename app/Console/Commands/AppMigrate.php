<?php

namespace App\Console\Commands;

use App\Models\App\Inquilino;
use Illuminate\Console\Command;

class AppMigrate extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'app:migrate {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the ACONCLOUD Application';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('BEGIN_INSTALL_APP');
        $this->call('migrate', ['--path' => 'database/migrations/app', '--force' => true]);
        if ($this->option('seed')) {
            $this->call('db:seed');
        }

        $inquilinos = Inquilino::all();
        $this->info("Migrando inquilinos");
        foreach($inquilinos as $inquilino){
            $this->info("Migrando inquilino: ".$inquilino->nombre);
            $inquilino->instalar();
        }
    }
}
