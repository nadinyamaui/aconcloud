<?php

namespace App\Console\Commands;

use App\Models\App\Inquilino;
use App\Models\Inquilino\Recibo;
use Illuminate\Console\Command;

class VerificarRecibosVencidos extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'recibos:verificar-vencidos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que busca en todos los inquilinos recibos vencidos.';

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
            $this->info("Verificando recibos vencidos");
            Recibo::verificarRecibosVencidos();
        });
    }
}
