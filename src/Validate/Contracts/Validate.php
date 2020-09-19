<?php

namespace Validate\Contracts;

interface Validate
{
    /**
     * Get a lock instance.
     *
     * @param  string $field
     * @return string
     */
    public static function toDatabase(string $field);

    /**
     * Restore a lock instance using the owner identifier.
     *
     * @param  string $field
     * @return string
     */
    public static function toUser($field);

    /**
     * Restore a lock instance using the owner identifier.
     *
     * @param  string $field
     * @return bool
     */
    public static function validate($field);
}
