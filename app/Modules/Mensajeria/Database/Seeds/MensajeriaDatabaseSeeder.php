<?php
namespace App\Modules\Mensajeria\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class MensajeriaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call('App\Modules\Mensajeria\Database\Seeds\FoobarTableSeeder');
    }
}
