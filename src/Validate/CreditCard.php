<?php

namespace Validate;

class CreditCard extends \Faker\Provider\Payment implements \Validate\Contracts\Validate
{

    public static function toDatabase($creditCardNumber)
    {
        return strtoupper(preg_replace('/[^0-9]/', '', $creditCardNumber));
    }

    public static function toUser($creditCardNumber)
    {
        return strtoupper(preg_replace('/[^0-9]/', '', $creditCardNumber));
    }

    public static function validate($creditCardNumber)
    {
        return true;
    }

    public static function mounth($year)
    {
        return Date::validateMonth($year);
    }

    public static function year($year)
    {
        return Date::yearToDatabase($year);
    }

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
