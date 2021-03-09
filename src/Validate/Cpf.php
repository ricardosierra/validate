<?php

namespace Validate;

use Validate\Traits\GetDataTrait;

class Cpf implements \Validate\Contracts\Validate
{
    use GetDataTrait;

    /**
     * Get User name from user and convert to Database
     *
     * @param  string $cpf
     * @return string
     */
    public static function toDatabase(string $cpf)
    {
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        return str_pad($cpf, 11, '0', STR_PAD_LEFT);
    }
    
    /**
     * Get User name from database and convert to User Format
     *
     * @param  string $cpf
     * @return string
     */
    public static function toUser($cpf)
    {
        return $cpf;
    }

    /**
     * Validate if Cpf is Valid
     *
     * @param  string $cpf
     * @return bool
     */
    public static function validate($cpf): bool
    {
        // Delete not Numbers || Elimina possivel mascara
        $cpf = self::toDatabase($cpf);
        
        // Verify Digit not can be 11 || Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        
        // Block Black Cpf's
        if (static::foundInFile($cpf, 'black-cpf')) {
            return false;
        }
        
         // Verify if Cpf is Valid || Calcula os digitos verificadores para verificar se o
         // CPF é válido
        for ($t = 9; $t < 11; $t++) {
            
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Verify if Cpf is the same
     *
     * @param  string $to
     * @param  string $from
     * @return boolean
     */
    public static function isSame(string $to, string $from): bool
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
