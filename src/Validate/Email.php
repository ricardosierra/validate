<?php

namespace Validate;

class Email extends Validate
{

    public static function validate($email)
    {
        $emailAddresse = explode("@", trim($email));

        if ($emailAddresse<2) {
            return false;
        }

        if (static::incluiInArray($emailAddresse[0], static::$notPermit)) {
            return false;
        }

        if (static::incluiInArray($emailAddresse[0], static::$notPermitInFirst)) {
            return false;
        }

        return true;
    }

}
