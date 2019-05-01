<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Cpf implements \Validate\Contracts\Validate
{
    use FakeNameTrait;

    public static function toDatabase($cpf)
    {
        return preg_replace('/[^0-9]/', '', $cpf);
    }
    
    public static function toUser($cpf)
    {
        return $cpf;
    }

    public static function validate($cpf)
    {

        return true;
    }

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
