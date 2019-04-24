<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Number implements \Validate\Contracts\Validate
{
    use FakeNameTrait;
    
    /**
     * Remove Virgulas do Numeral e Add .
     */
    public static function toDatabase(string $number)
    {
        if(strpos($number, ',') > 0) {
            $number = str_replace('.', '', $number);
            $number = str_replace(',', '.', $number);
        }
        return $number;
    }

    public static function toUser($number)
    {
        return $number;
    }

    public static function validate($number)
    {
        return true;
    }

}
