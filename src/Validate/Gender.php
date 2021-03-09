<?php

namespace Validate;

use Validate\Traits\GetDataTrait;

class Gender implements \Validate\Contracts\Validate
{
    use GetDataTrait;

    public static function toDatabase(string $gender)
    {
        return substr(((string) self::filter(strtoupper(preg_replace('/[^A-z]/', '', $gender)))), 0, 1);
    }

    public static function filter(string $gender)
    {
        if (static::foundInFile($gender, 'gender-names-to-male')) {
            return 'MASCULINO';
        }
        if (static::foundInFile($gender, 'gender-names-to-woman')) {
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

    public static function validate($gender): bool
    {
        $gender = self::toDatabase($gender);

        if ($gender !== 'U' && $gender !== 'M' && $gender !== 'F') {
            return false;
        }

        return true;
    }

    public static function isSame(string $to, string $from): bool
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
