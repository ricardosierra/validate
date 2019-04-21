<?php

namespace Validate;

abstract class Validate
{
    public static $notPermit = [
        'TESTE',
        'TESTANDO',
        'TESTADOR'
    ];
    public static $notPermitInFirst = [
        'CURIOSO'
    ];

    public static function incluiInArray($field, $array)
    {
        foreach ($array as $notPermit) {
            if(strpos(self::toDatabase($field), $notPermit) !=0){
                return true;
            }
        }
        return false;
    }

    public static function toDatabase($field)
    {
        return $field;
    }

    public static function toUser($field)
    {
        return $field;
    }

}
