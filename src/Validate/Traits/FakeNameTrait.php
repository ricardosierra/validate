<?php

namespace Validate\Traits;

trait FakeNameTrait
{
    public static $notPermit = [
        'TEST',
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
}