<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Cep implements \Validate\Contracts\Validate
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

}
