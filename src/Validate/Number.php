<?php

namespace Validate;

class Number implements \Validate\Contracts\Validate
{
    
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

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
