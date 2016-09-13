<?php namespace App\Jobs;

use App\Models\App\Inquilino;

abstract class Job
{

    /**
     * @var Inquilino
     */
    protected $inquilino;

    public function __construct()
    {
        $this->inquilino = Inquilino::$current;
    }

    public function initialize()
    {
        Inquilino::setActivo($this->inquilino->host);
    }
}
