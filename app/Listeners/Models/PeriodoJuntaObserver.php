<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Models\Inquilino\PeriodoJunta;

class PeriodoJuntaObserver extends BaseObserver
{

    public function deleting(PeriodoJunta $periodo)
    {
        $users = $periodo->usuarios;
        $users->each(function ($user) {
            $user->delete();
        });

        return true;
    }
}
