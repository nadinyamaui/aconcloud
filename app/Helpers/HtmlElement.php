<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 16-04-2015
 * Time: 01:29 PM
 */

namespace App\Helpers;

class HtmlElement
{

    public $type;
    public $name;
    public $label;

    public function __construct($type, $name)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = str_replace('[]', '', ucfirst($this->name));
    }

    public function render($value)
    {
        $id = str_replace('[]', '', $this->name);

        return ("<input type='{$this->type}' value='{$value}' name='{$this->name}' id='{$id}'>");
    }
}
