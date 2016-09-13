<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Jobs\InquilinoComprado;
use App\Models\App\Inquilino;

class InquilinoObserver extends BaseObserver
{

    public function created(Inquilino $model)
    {
        $this->dispatcher->dispatch(new InquilinoComprado($model));
    }

    public function deleting(Inquilino $model)
    {
        $model->modulos()->detach();
        $model->usuarios()->detach();
        $model->smsEnviados()->delete();
        return true;
    }
}