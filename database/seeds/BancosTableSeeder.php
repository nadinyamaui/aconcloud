<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Models\App\Banco;

/**
 * Description of TenantTableSeeder
 *
 * @author nadinarturo
 */
class BancosTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        $bancos = [
            'Banco Mercantil',
            'Banesco',
            'Venezolano de Credito',
            'Banco de Venezuela',
            '100% Banco',
            'Banco Bicentenario',
            'Banco Provincial',
        ];
        foreach ($bancos as $banco) {
            Banco::create(['nombre' => $banco]);
        }
    }

}
