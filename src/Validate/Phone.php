<?php

namespace Validate;

class Phone implements \Validate\Contracts\Validate
{

    public static function toDatabase(string $phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr((string) $phone, 0, 2)=='55') {
            return $phone;
        }
        if (empty($phone) || $phone=='55') {
            return null;
        }
        if (strlen($phone)>11) {
            return $phone;
        }
        return '55'.$phone;
    }

    public static function toUser($phone)
    {
        return $phone;
    }

    public static function validate($phoneNumber): bool
    {
        $phone = self::break($phoneNumber);

        if ((int) $phone['country'] === 0 ) {
            return false;
        }

        if ((int) $phone['region'] === 0 ) {
            return false;
        }

        if ((int) $phone['number'] === 0 ) {
            return false;
        }

        if (strlen(static::toDatabase($phoneNumber)) < 12 || strlen(static::toDatabase($phoneNumber)) > 13) {
            return false;
        }

        return true;
    }

    public static function break(string $phone): array
    {
        $phone = static::toDatabase($phone);
        $data['country'] = '55';
        $data['region'] = '61';

        if (strlen($phone)>=12) {
            $data['country'] = substr((string) $phone, 0, 2);
            $phone = substr((string) $phone, 2, strlen($phone)-2);
        }

        if (strlen($phone)>=10) {
            $data['region'] = substr((string) $phone, 0, 2);
            $phone = substr((string) $phone, 2, strlen($phone)-2);
        }

        $data['number'] = $phone;
        return $data;
    }

    public static function isSame(string $to, string $from): bool
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
