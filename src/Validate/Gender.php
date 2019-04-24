<?php

namespace Validate;

class Gender extends Validate
{

    public static function toDatabase($gender)
    {
        return parent::toDatabase(strtoupper(preg_replace('/[^0-9]/', '', substr($gender, 0, 1))));
    }

    public static function toUser($gender)
    {
        if($gender == 'M') {
            return 'Masculino';
        }
        
        if($gender == 'F') {
            return 'Feminino';
        }
        
        return 'Unissex';
    }

    public static function validate($gender)
    {

        return true;
    }

}
