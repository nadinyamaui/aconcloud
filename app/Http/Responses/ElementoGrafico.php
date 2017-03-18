<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30-03-2015
 * Time: 04:55 PM
 */

namespace App\Http\Responses;

class ElementoGrafico
{

    public $label;
    public $value;

    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }
}
