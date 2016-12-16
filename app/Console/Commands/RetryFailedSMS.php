<?php

namespace App\Console\Commands;

use App\Jobs\SendSmsToCentauro;
use App\Models\App\SmsEnviado;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class RetryFailedSMS extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sms:retry_failed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check the sms sent table and retry the failed ones';

    public function handle()
    {
        $failed = SmsEnviado::whereIndFallido(true)->get();
        $failed->each(function (SmsEnviado $smsEnviado) {
            $this->info("Sending SMS #" . $smsEnviado->id);
            $this->dispatch(new SendSmsToCentauro($smsEnviado));
        });
    }
}
