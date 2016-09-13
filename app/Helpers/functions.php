<?php

function p($variable)
{
    return \App\Models\Inquilino\Preferencia::buscar($variable);
}