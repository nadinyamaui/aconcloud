<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CargarPanelesAdicionales extends Event
{
    use SerializesModels;

    public $item;
    public $paneles;

    public function __construct($item, $paneles)
    {
        $this->item = $item;
        $this->paneles = $paneles;
    }
}
