<?php

namespace Validate;

class Date extends Validate
{

    public static function toDatabase($date)
    {
        return parent::toDatabase(strtoupper($date));
    }

    public static function validate($date)
    {
        $nomes = explode(" ", trim($date));

        if ($nomes<2) {
            return false;
        }

        if (static::incluiInArray($name, static::$notPermit)) {
            return false;
        }

        if (static::incluiInArray($nomes[0], static::$notPermitInFirstName)) {
            return false;
        }

        if (filter_var($date, FILTER_SANITIZE_NUMBER_INT) !== '') {
            return false;
        }

        return true;
    }

}
