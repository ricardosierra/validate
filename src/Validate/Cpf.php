<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Cpf implements \Validate\Contracts\Validate
{
    use FakeNameTrait;

    public static $invalidCpfs = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999'
    ];

    public static function toDatabase($cpf)
    {
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        return str_pad($cpf, 11, '0', STR_PAD_LEFT);
    }
    
    public static function toUser($cpf)
    {
        return $cpf;
    }

    public static function validate($cpf)
    {
        // Elimina possivel mascara
        $cpf = self::toDatabase($cpf);
        
        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        if (
            in_array(
                $cpf,
                self::$invalidCpfs
            )
            ) {
            return false;
         } 
         // Calcula os digitos verificadores para verificar se o
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

    public static function isSame(string $to, string $from)
    {
        return (self::toDatabase($to)===self::toDatabase($from));
    }

}
