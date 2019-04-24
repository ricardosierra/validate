<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Gender implements \Validate\Contracts\Validate
{
    use FakeNameTrait;
    
    public static $toMale = [
        'MASCULINO',
        'HOMEM',
        'MALE',
        'MACHO'
    ];
    public static $toWoman = [
        'FEMININO',
        'MULHER',
        'WOMAN',
        'FEMIA'
    ];

    public static function toDatabase($gender)
    {
        return substr(((string) self::filter(strtoupper(preg_replace('/[^A-z]/', '',$gender)))), 0, 1);
    }

    public static function filter($gender) {
        if (static::incluiInArray($gender, static::$toMale)) {
            return 'MASCULINO';
        }
        if (static::incluiInArray($gender, static::$toWoman)) {
            return 'FEMININO';
        }
        return $gender;
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
        $gender = self::toDatabase($gender);

        if ($gender !== 'U' && $gender !== 'M' && $gender !== 'F') {
            return false;
        }

        return true;
    }

}
