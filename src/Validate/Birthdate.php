<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Birthdate extends Date implements \Validate\Contracts\Validate
{
    use FakeNameTrait;

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

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
