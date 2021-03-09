<?php

namespace Validate;

use GuzzleHttp\Client as Http;
use Exception;

class Cep implements \Validate\Contracts\Validate
{

    public static function toDatabase(string $cep)
    {
        return preg_replace('/[^0-9]/', '', trim($cep));
    }
    
    public static function toUser($cep)
    {
        return $cep;
    }

    public static function validate($cep): bool
    {
        if (preg_match('/[0-9]{2,2}([.]?)[0-9]{3,3}([- ]?)[0-9]{3}$/', $cep) == 0 ) {            
            return false;
        }
        try {
            $client = new Http();
            $res = $client->request('GET', 'https://viacep.com.br/ws/'.self::toDatabase($cep).'/json/');
            if ($res->getStatusCode() !== 200) {
                return false;
            }
            $json = json_decode($res->getBody());
            if (isset($json->error) && $json->error = true) {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public static function isSame(string $to, string $from): bool
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
