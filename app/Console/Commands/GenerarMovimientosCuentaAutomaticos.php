<?php

namespace App\Console\Commands;

use App\Models\App\Inquilino;
use App\Models\Inquilino\ClasificacionIngresoEgreso;
use Illuminate\Console\Command;

class GenerarMovimientosCuentaAutomaticos extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clasificaciones:generar-automaticos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar movimientos de cuenta automaticos.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $inquilinos = Inquilino::all();
        $this->info("Buscando inquilinos");
        $inquilinos->each(function ($inquilino) {
            $this->info("Activando inquilino: " . $inquilino->nombre);
            Inquilino::setActivo($inquilino->host);
            $this->info("Generando movimientos automaticos");
            ClasificacionIngresoEgreso::generarMovimientosAutomaticos();
            $this->info("Movimientos automaticos generados");
        });
    }
}
