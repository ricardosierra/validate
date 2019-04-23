<?php

namespace Validate;

class Date extends Validate
{

    public static function toDatabase($date)
    {
        $data = explode('/', $dataOriginal);
        if (isset($data[2])){
            if($data[1]>12){
                return $data[2] .'-'. $data[0] .'-'. $data[1];
            }            
            return $data[2] .'-'. $data[1] .'-'. $data[0];
        }
        return parent::toDatabase($dataOriginal);
    }

    public static function dateToUser($data)
    {
        return $data;
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

}
