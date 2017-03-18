<?php

namespace App\Listeners\Models;

use App\Models\Inquilino\Alarma;

class AlarmaObserver extends BaseObserver
{

    public function deleting(Alarma $model)
    {
        $model->users()->detach();

        return true;
    }
}
