<?php

namespace Validate;

class Cpf extends Validate
{

    public static function toDatabase($cpf)
    {
        return parent::toDatabase(preg_replace('/[^0-9]/', '', $cpf));
    }

    public static function validate($cpf)
    {

        return true;
    }

}
