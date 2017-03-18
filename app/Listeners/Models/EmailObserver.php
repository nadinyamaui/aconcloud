<?php

namespace App\Listeners\Models;

use App\Jobs\EnviarEmail;
use App\Models\Inquilino\Email;

class EmailObserver extends BaseObserver
{

    public function created(Email $email)
    {
        $this->dispatcher->dispatch(new EnviarEmail($email->id));
    }
}
