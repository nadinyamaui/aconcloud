<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

class AyudaObserver extends BaseObserver
{

    public function saving($model)
    {
        $model->autor_id = \Auth::id();

        return parent::saving($model);
    }
}