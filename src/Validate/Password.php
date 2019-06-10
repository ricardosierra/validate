<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

class Password implements \Validate\Contracts\Validate
{
    use FakeNameTrait;

    public static function toDatabase(string $password)
    {
        // Change @todo
        return md5($password);
    }

    public static function toUser($password)
    {
        return $password;
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
