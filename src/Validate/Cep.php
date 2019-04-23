<?php

namespace Validate;

class Cep extends Validate
{

    public static function toDatabase($cep)
    {
        return parent::toDatabase(trim($cep));
    }

    public static function validate($cep)
    {
        if (preg_match('/[0-9]{2,2}([.]?)[0-9]{3,3}([- ]?)[0-9]{3}$/', self::toDatabase($cep))) {            
            return true;
        }
        return false;
    }

}
