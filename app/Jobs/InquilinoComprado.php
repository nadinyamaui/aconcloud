<?php namespace App\Jobs;

use App\Models\Inquilino\Email;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InquilinoComprado extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($inquilino)
    {
        parent::__construct();
        $this->inquilino = $inquilino;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(Mailer $mail)
    {
        $data['host'] = $this->inquilino->host;
        $data['asunto'] = '¡Gracias por adquirir aconcloud!';
        $nombre = $this->inquilino->nombre;
        $email = $this->inquilino->email_administrador;
        $mail->send('emails.inquilino.created', $data, function ($message) use ($nombre, $email) {
            $message->to($email, $nombre)->subject('¡Gracias por adquirir aconcloud!');
        });
    }
}
