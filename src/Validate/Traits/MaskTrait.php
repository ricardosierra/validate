<?php

namespace Validate\Traits;

/**
 * Undocumented trait
 */
trait MaskTrait
{

    public static function maskIsValidate($number, $mask)
    {
        $i = 0;
        $maskLen = strlen($mask);
        $numberLen = strlen($number);
        if ($maskLen !== $numberLen) {
            return false;
        }
        while($i < $maskLen) {
            if (strtoupper($mask[$i])!=='X' && strtoupper($mask[$i])!=='#'){
                if ($mask[$i]!==$number[$i]) {
                    return false;
                }
            }
            $i = $i + 1;
        }
        return true;
    }

}