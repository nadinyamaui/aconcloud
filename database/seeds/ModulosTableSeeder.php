<?php


use App\Models\App\Modulo;

class ModulosTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        Modulo::create([
            'codigo'        => 'mensajeria',
            'nombre'        => 'Mensajeria Interna',
            'descripcion'   => 'Mensajeria Interna',
            'costo_mensual' => '0,00',
        ]);
    }

}
