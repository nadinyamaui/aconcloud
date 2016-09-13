<?php namespace App\Jobs;

use App\Models\App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\App\Inquilino;

class UsuarioRegistrado extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $host;

    public function __construct(User $user, $host)
    {
        parent::__construct();
        $this->user = $user;
        $this->host = $host;
    }

    public function handle()
    {
        Inquilino::setActivo($this->inquilino->host);
        $data['usuario'] = $this->user;
        $data['host'] = $this->host;
        $data['usuario']->enviarCorreo('emails.usuarios.created', $data, '¡Bienvenido a aconcloud!');
    }

}
