<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "s3", "rackspace"
    |
    */

    'default' => 'local',
    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud'   => 'dropbox',
    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks'   => [
        'local'     => [
            'driver' => 'local',
            'root'   => storage_path() . '/app/archivos',
        ],
        'local_public' => [
            'driver' => 'local',
            'root'   => public_path() . '/uploads',
        ],

        'dropbox' => [
            'driver'       => 'dropbox',
            'access_token' => env('DROPBOX_ACCESS_TOKEN'),
            'app_secret'   => env('DROPBOX_APP_SECRET'),
        ],
    ],

];
