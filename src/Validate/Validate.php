<?php

namespace Validate;

use Validate\Traits\FakeNameTrait;

abstract class Validate implements \Validate\Contracts\Validate
{
    use FakeNameTrait;

    public static function toDatabase($field)
    {
        return $field;
    }

    public static function toUser($field)
    {
        return $field;
    }

}
