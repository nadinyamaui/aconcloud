<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class DatesUpgrade extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dates:upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all timestamps columns and make it nullable with default value of null';

    protected $database;

    public function handle()
    {
        $columns = DB::table('information_schema.COLUMNS')
            ->whereIn('COLUMN_NAME', ['created_at', 'updated_at', 'deleted_at'])
            ->where('data_type', 'timestamp')
            ->where('COLUMN_DEFAULT', '0000-00-00 00:00:00')
            ->select(['TABLE_SCHEMA', 'TABLE_NAME', 'COLUMN_NAME'])->get();

        $this->output->progressStart(count($columns));
        foreach ($columns as $column) {
            $this->output->progressAdvance();
            DB::statement("ALTER TABLE `{$column->TABLE_SCHEMA}`.`{$column->TABLE_NAME}` MODIFY COLUMN `{$column->COLUMN_NAME}` timestamp NULL DEFAULT NULL;");
        }

        $this->output->progressFinish();
    }
}
