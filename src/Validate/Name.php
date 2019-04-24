<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Name implements \Validate\Contracts\Validate
{
    use FakeNameTrait;

    public static function toDatabase(string $fullName)
    {
        return strtoupper($fullName);
    }

    public static function toUser($fullName)
    {
        return $fullName;
    }

    public static function validate($fullName)
    {
        $name = self::break($fullName);

        if ($name['sobrenomes'] < 1) {
            return false;
        }

        if (static::incluiInArray($name['full'], static::$notPermit)) {
            return false;
        }

        if (static::incluiInArray($name['first'], static::$notPermitInFirst)) {
            return false;
        }

        if (filter_var($name['full'], FILTER_SANITIZE_NUMBER_INT) !== '') {
            return false;
        }

        return true;
    }

    public static function break($fullName)
    {
        $fullName = self::toDatabase($fullName);
        $nomes = explode(" ", trim($fullName));
        return [
            'first' => $nomes[0],
            'names' => $nomes,
            'full' => $fullName,
            'last' => $nomes[count($nomes)-1],
            'sobrenomes' => count($nomes)-1
        ];
    }

}
