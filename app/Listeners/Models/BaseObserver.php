<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use Illuminate\Bus\Dispatcher;

class BaseObserver
{

    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher = null)
    {
        $this->dispatcher = $dispatcher;
    }

    public function saving($model)
    {
        if (!isset($model->id) && method_exists($model, 'getDefaultValues')) {
            $default = $model->getDefaultValues();
            $model->setRawAttributes(array_merge($default, $model->getAttributes()));
        }

        return $model->validate();
    }
}
