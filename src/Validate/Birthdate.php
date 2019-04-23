<?php

namespace Validate;

class Birtydate extends Date
{

    public static function toDatabase($birthdate)
    {
        return parent::toDatabase(strtoupper($birthdate));
    }

    public static function validate($birthdate)
    {
        $nomes = explode(" ", trim($birthdate));

        if ($nomes<2) {
            return false;
        }

        if (static::incluiInArray($name, static::$notPermit)) {
            return false;
        }

        if (static::incluiInArray($nomes[0], static::$notPermitInFirstName)) {
            return false;
        }

        if (filter_var($birthdate, FILTER_SANITIZE_NUMBER_INT) !== '') {
            return false;
        }

        return true;
    }

}
