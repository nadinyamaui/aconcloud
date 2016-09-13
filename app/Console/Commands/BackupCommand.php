<?php

namespace App\Console\Commands;

use App\Services\DatabaseBackupHandler;
use Symfony\Component\Process\Process;

class BackupCommand extends \Spatie\Backup\Commands\BackupCommand
{
    /**
     * Return an array with path to files that should be backed up.
     *
     * @return array
     */
    protected function getAllFilesToBeBackedUp()
    {
        $files = [];

        if (config('laravel-backup.source.backup-db')) {
            $databaseBackupHandler = app()->make(DatabaseBackupHandler::class);
            foreach ($databaseBackupHandler->getFilesToBeBackedUp() as $key => $file) {
                $files[] = ['realFile' => $file, 'fileInZip' => 'db/' . $key . '.sql'];
            }
            $this->comment('Database dumped');
        }

        if ($this->option('only-db')) {
            return $files;
        }

        $this->comment('Determining which files should be backed up...');
        $fileBackupHandler = app()->make('Spatie\Backup\BackupHandlers\Files\FilesBackupHandler')
            ->setIncludedFiles(config('laravel-backup.source.files.include'))
            ->setExcludedFiles(config('laravel-backup.source.files.exclude'));
        foreach ($fileBackupHandler->getFilesToBeBackedUp() as $file) {
            $files[] = ['realFile' => $file, 'fileInZip' => 'files/' . $file];
        }

        return $files;
    }
}
