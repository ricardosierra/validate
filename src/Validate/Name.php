<?php

namespace Validate;

class Name extends Validate
{
    public static $notPermit = [
        'TESTE',
        'TESTANDO',
        'TESTADOR'
    ];
    public static $notPermitInFirstName = [
        'CURIOSO'
    ];

    public static function incluiInArray($name, $array)
    {
        foreach ($array as $notPermit) {
            if(strpos(self::toDatabase($name), $notPermit) !=0){
                return true;
            }
        }
        return false;
    }

    public static function toDatabase($fullName)
    {
        return $fullName;
    }

    public static function validate($fullName)
    {
        $nomes = explode(" ", trim($fullName));

        if ($nomes<2) {
            return false;
        }

        if (self::incluiInArray($name, self::$notPermit)) {
            return false;
        }

        if (self::incluiInArray($nomes[0], self::$notPermitInFirstName)) {
            return false;
        }

        if (filter_var($fullName, FILTER_SANITIZE_NUMBER_INT) !== '') {
            return false;
        }

        return true;
    }

}
