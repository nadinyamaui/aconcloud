<?php namespace App\Jobs;

use App\Models\App\Inquilino;
use App\Models\Inquilino\Alarma;
use App\Models\Inquilino\Email;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $email_id;

    public function __construct($email_id)
    {
        parent::__construct();
        $this->email_id = $email_id;
    }

    public function handle(Mailer $mailer)
    {
        Inquilino::setActivo($this->inquilino->host);
        $email = Email::findOrFail($this->email_id);
        $mailer->send([], [], function (Message $message) use ($email) {
            $message->getSwiftMessage()->setBody($email->cuerpo, 'text/html');
            $message->subject($email->asunto);
            $message->to($email->destinatario, $email->nombre_destinatario);
            $email->enviado();
        });
    }
}
