<?php

namespace App\Services;

use App\Models\App\Inquilino;
use Exception;

class DatabaseBackupHandler extends \Spatie\Backup\BackupHandlers\Database\DatabaseBackupHandler
{
    /**
     * Get database configuration.
     *
     * @param string $database
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getDatabase($database = '')
    {
        $databaseConnection = config('database.connections.app');
        if ($database != '') {
            $databaseConnection['database'] = $database;
        }

        return $this->databaseBuilder->getDatabase($databaseConnection);
    }

    public function getDumpedDatabase($database = '')
    {
        $tempFile = tempnam(sys_get_temp_dir(), "laravel-backup-db-" . $database);

        $success = $this->getDatabase($database)->dump($tempFile);

        if (!$success || filesize($tempFile) == 0) {
            dd($tempFile, $database);
            throw new Exception('Could not create backup of db');
        }

        return $tempFile;
    }

    /**
     * Returns an array of files which should be backed up.
     *
     * @return array
     */
    public function getFilesToBeBackedUp()
    {
        $baseDb = config('database.connections.app.database');
        $return = [];

        $return[$baseDb] = $this->getDumpedDatabase();
        $tenants = Inquilino::all();
        foreach ($tenants as $tenant) {
            $tenantDb = $baseDb . '_' . $tenant->id;
            $return[$tenantDb] = $this->getDumpedDatabase($tenantDb);
        }

        return $return;
    }
}
