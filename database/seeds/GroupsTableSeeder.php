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
use App\Models\App\Grupo;

class GroupsTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        Grupo::create(['nombre' => 'Administrador', 'codigo' => 'admin']);
        Grupo::create(['nombre' => 'Miembro de la junta', 'codigo' => 'junta']);
        Grupo::create(['nombre' => 'Propietario', 'codigo' => 'propietario']);
        Grupo::create(['nombre' => 'Alquilado', 'codigo' => 'alquilado']);
    }
}
