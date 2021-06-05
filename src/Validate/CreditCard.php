<?php

namespace Validate;

use Carbon\Carbon;
use Validate\Traits\MaskTrait;

class CreditCard extends \Faker\Provider\Payment implements \Validate\Contracts\Validate
{
    use MaskTrait;

    public static function toDatabase(string $creditCardNumber)
    {
        return strtoupper(preg_replace('/[^0-9]/', '', $creditCardNumber));
    }

    public static function toUser($creditCardNumber)
    {
        return strtoupper(preg_replace('/[^0-9]/', '', $creditCardNumber));
    }

    public static function validate($creditCardNumber): bool
    {
        $found = false;
        foreach (self::$cardParams as $masks){
            foreach ($masks as $mask){
                if (self::maskIsValidate($creditCardNumber, $mask)) {
                    $found = true;
                }
            }
        }
        return $found;
    }

    public static function expirationIsValid($mes, $ano)
    {
        if ((int) Date::yearToDatabase($ano) < (int) Carbon::now()->year) {
            return false;
        }
        if ((int) Date::yearToDatabase($ano) == (int) Carbon::now()->year) {
            if ((int) Date::monthToDatabase($mes) < (int) Carbon::now()->month) {
                return false;
            }
        }
        return true;
    }

    public static function month($year)
    {
        return Date::validateMonth($year);
    }

    public static function year($year)
    {
        return Date::yearToDatabase($year);
    }

    public static function isSame(string $to, string $from): bool
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
