<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Listeners\Models;

use App\Jobs\UsuarioRegistrado;
use App\Models\App\Inquilino;
use App\Models\App\User;

class UserObserver extends BaseObserver
{

    public function deleting(User $model)
    {
        return true;
    }

    public function created($model)
    {
        if (is_object(Inquilino::$current)) {
            $this->dispatcher->dispatch(new UsuarioRegistrado($model, Inquilino::$current->host));
        }
    }
}
