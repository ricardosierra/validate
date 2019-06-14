<?php

namespace Validate;

use Validate\Traits\BlockStringTrait;
use Validate\Traits\GetDataTrait;

/**
 * I created this validator just to avoid common passwords, you should not use to store passwords.
 * Not before you improve that shit!
 * 
 * Criei esse validator apenas para evitar senhas comuns, você não deveria usar para armazenar senhas.
 * Não antes de melhorar essa merda!
 */
class Password implements \Validate\Contracts\Validate
{
    use BlockStringTrait, GetDataTrait;
    
    /**
     * Create hash for store password
     *
     * @param string $password
     * @return string
     */
    public static function toDatabase(string $password)
    {
        return sha256($password);
    }

    /**
     * Never use this function
     *
     * @param string $password
     * @return void
     */
    public static function toUser($password)
    {
        // @todo Nem deveria existir isso aqui !
        die();
        return null;
    }

    /**
     * Verify if client use commoms passwords.
     * 
     * @todo Create validate for password force
     *
     * @param string $password
     * @param integer $force
     * @return void
     */
    public static function validate($password, $force = 0)
    {
        if (self::foundInMultiplesArrays([
            [
                $password,
                self::getListFromFile('black-passwords')
            ],
            [
                $password,
                self::getListFromFile('black-names')
            ],
            [
                $password,
                self::getListFromFile('black-first-names')
            ],
        ])){
            return false;
        }

        return true;
    }

    /**
     * Verify 
     *
     * @param string $fromDatabase
     * @param string $fromUser
     * @return boolean
     */
    public static function isSame(string $fromDatabase, string $fromUser)
    {
        return (self::toDatabase($fromDatabase)===self::toDatabase($fromUser));

    }

    public static function generate(
        $length = 8,
        $keyspace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%'
    ) {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }


}
