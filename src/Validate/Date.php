<?php

namespace Validate;

use Carbon\Carbon;

class Date implements \Validate\Contracts\Validate
{
    public static function toDatabase($dataOriginal)
    {
        $data = explode('/', $dataOriginal);
        if (isset($data[2])){
            if($data[1]>12){
                return $data[2] .'-'. $data[0] .'-'. $data[1];
            }            
            return $data[2] .'-'. $data[1] .'-'. $data[0];
        }
        return $dataOriginal;
    }

    public static function toUser($data)
    {
        return $data;
    }

    public static function validate($dataOriginal)
    {
        $data = self::toDatabase($dataOriginal);
        if (Carbon::createFromFormat('Y-m-d', $data) !== false) {
            return true;
        }
        return true;
    }


    public static function validateYear($year)
    {
        return true;
    }

    public static function validateYearPresentOrFuturo($year)
    {
        return true;
    }

    public static function validateMonth($month)
    {
        $month = (int) $month;
        if ($month>12) {
            return false;
        }
        return true;
    }

    public static function yearToDatabase($year)
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

    public static function monthToDatabase($month)
    {
        return $month;
    }

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
