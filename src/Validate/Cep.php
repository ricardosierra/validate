<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Cep implements \Validate\Contracts\Validate
{
    use FakeNameTrait;

    public static function toDatabase($cep)
    {
        return preg_replace('/[^0-9]/', '', trim($cep));
    }
    
    public static function toUser($cep)
    {
        return $cep;
    }

    public static function validate($cep)
    {
        if (preg_match('/[0-9]{2,2}([.]?)[0-9]{3,3}([- ]?)[0-9]{3}$/', self::toDatabase($cep))) {            
            return true;
        }
        return false;
    }

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
