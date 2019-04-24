<?php

namespace Validate;

class Birthdate extends Date
{

    public static function toDatabase($birthdate)
    {
        return parent::toDatabase($birthdate);
    }

    public static function validate($birthdate)
    {   
        if (!parent::validate($birthdate)){
            return false;
        }

        return true;
    }

}
