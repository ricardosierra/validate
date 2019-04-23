<?php

namespace Validate;

class Phone extends Validate
{

    public static function toDatabase($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone,0,2)=='55') {
            return $phone;
        }
        if (empty($phone) || $phone=='55') {
            return null;
        }
        if (strlen($phone)>11) {
            return parent::toDatabase($phone);
        }
        return parent::toDatabase('55'.$phone);
    }

    public static function validate($phone)
    {
        $phone = self::break($phone);

        if ((int) $phone['country'] === 0 ) {
            return false;
        }

        if ((int) $phone['region'] === 0 ) {
            return false;
        }

        if ((int) $phone['number'] === 0 ) {
            return false;
        }

        return true;
    }

    public static function break($phone)
    {
        $phone = static::toDatabase($phone);
        $data['country'] = '55';
        $data['region'] = '61';

        var_dump('oi'.$phone.'-'.strlen($phone));


        if (strlen($phone)>=12) {
            $data['country'] = substr($phone, 0, 2);
            $phone = substr($phone, 2, strlen($phone)-2);
        }

        if (strlen($phone)>=10) {
            $data['region'] = substr($phone, 0, 2);
            $phone = substr($phone, 2, strlen($phone)-2);
        }

        $data['number'] = $phone;
        return $data;
    }

}
