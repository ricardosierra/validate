<?php

namespace Validate;

use Carbon\Carbon;

class Birthdate extends Date implements \Validate\Contracts\Validate
{
    public static function toDatabase($birthdate)
    {
        return parent::toDatabase($birthdate);
    }

    public static function validate($birthdate)
    {   
        if (!parent::validate($birthdate)){
            return false;
        }

        $birthdate = Carbon::createFromFormat('Y-m-d', self::toDatabase($birthdate));
        if ($birthdate->greaterThan(Carbon::now())){
            return false;
        }

        return true;
    }

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
