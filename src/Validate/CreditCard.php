<?php

namespace Validate;

class CreditCard extends Validate
{

    public static function toDatabase($fullName)
    {
        return parent::toDatabase(strtoupper($fullName));
    }

    public static function validate($fullName)
    {
        $nomes = explode(" ", trim($fullName));

        if ($nomes<2) {
            return false;
        }

        if (static::incluiInArray($name, static::$notPermit)) {
            return false;
        }

        if (static::incluiInArray($nomes[0], static::$notPermitInFirstName)) {
            return false;
        }

        if (filter_var($fullName, FILTER_SANITIZE_NUMBER_INT) !== '') {
            return false;
        }

        return true;
    }

    public static function year($year)
    {
        $year = (int) $year;
        
        if ($year>99) {
            return $year;
        }
        if ($year>50){
            return 1900+$year;
        }
        return 2000+$year;
    }

}
