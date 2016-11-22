<?php

namespace App\Jobs;

use App\Models\App\SmsEnviado;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Yaml\Exception\ParseException;

class SendSmsToCentauro extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var SmsEnviado
     */
    protected $sms;

    /**
     * Create a new job instance.
     *
     * @param SmsEnviado $smsEnviado
     */
    public function __construct(SmsEnviado $smsEnviado)
    {
        parent::__construct();
        $this->sms = $smsEnviado;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://api.centaurosms.com.ve',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'timeout' => 60.0,
        ]);

        $message = [];
        try {
            $message = $client->request('POST', 'controllersms/', [
                'body' => $this->prepareBasicData($this->sms->destinatario->telefono_celular, $this->sms->mensaje)
            ])->json();
        } catch (ServerException $e) {
            $this->sms->error = $e->getMessage();
        } catch (ParseException $e) {
            $this->sms->error = $e->getMessage();
        }

        if (array_get($message, 'status') == '200') {
            $this->sms->error = "Enviado";
        } else if (isset($message['status'])) {
            $this->sms->error = $message['status'];
        }

        $this->sms->ind_enviado = true;
        $this->sms->save();
    }

    protected function prepareBasicData($destination, $msg, $option = 'send_sms')
    {
        $json = [
            'id' => '0',
            'cel' => $destination,
            'nom' => ''
        ];
        return http_build_query([
            'client_id' => '166599084061540',
            'client_secret' => 'CqiPNAlvXKKBCcacbJTH',
            'json' => base64_encode(urlencode(json_encode($json))),
            'msg' => base64_encode(urlencode($msg)),
            'client_opcion' => $option
        ]);
    }
}