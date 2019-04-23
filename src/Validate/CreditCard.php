<?php

namespace Validate;

class CreditCard extends Validate
{

    public static function toDatabase($creditCardNumber)
    {
        return parent::toDatabase(strtoupper($creditCardNumber));
    }

    public static function validate($creditCardNumber)
    {
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
