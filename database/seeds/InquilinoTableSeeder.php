<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TenantTableSeeder
 *
 * @author nadinarturo
 */
use App\Models\App\Inquilino;

class InquilinoTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        Inquilino::create([
            'nombre'              => 'Administrador',
            'host'                => 'aconcloud.local',
            'descripcion'         => 'Inquilino admnistrador',
            'email_administrador' => 'arasmit_yamaui@hotmail.com',
        ]);
    }
}
