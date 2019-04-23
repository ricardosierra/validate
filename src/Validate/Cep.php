<?php

namespace Validate;

class Cep extends Validate
{

    public static function toDatabase($cep)
    {
        return parent::toDatabase(preg_replace('/[^0-9]/', '', $cep));
    }

    public static function validate($cep)
    {

        return true;
    }

}
