<?php

namespace Validate;

class CreditCard extends Validate
{
    /**
     * Remove Virgulas do Numeral e Add .
     */
    public static function toDatabase($number)
    {
        if(strpos($number, ',') > 0) {
            $number = str_replace('.', '', $number);
            $number = str_replace(',', '.', $number);
        }
        return parent::toDatabase($number);
    }

    public static function toUser($number)
    {
        return $number;
    }

    public static function validate()
    {
        return true;
    }

}
