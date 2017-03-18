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
use App\Models\App\InquilinoUser;
use App\Models\App\User;

class UsuarioTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        $user = User::create([
            'nombre'   => 'Nadin',
            'apellido' => 'Yamaui',
            'password' => \Hash::make('123456'),
            'email'    => 'arasmit_yamaui@hotmail.com'
        ]);

        InquilinoUser::create([
            'user_id'      => $user->id,
            'inquilino_id' => 1,
            'grupo_id'     => 1,
        ]);
    }
}
