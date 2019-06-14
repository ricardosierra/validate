<?php

namespace Validate\Traits;

/**
 * Undocumented trait
 */
trait GetDataTrait
{

    /**
     * Get full file url
     *
     * @param string $file
     * @return string
     */
    public static function getFileUrl($file)
    {
        $rootDir = "..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..";
        return dirname(__FILE__).$rootDir.DIRECTORY_SEPARATOR.$file;
    }

    /**
     * Return array from file
     *
     * @param string $file
     * @return array
     */
    public static function getListFromFile($file)
    {
        return file(self::getFileUrl($file));
    }

    /**
     * Found string inside file
     *
     * @param string $string
     * @param string $file
     * @return bool
     */
    public static function foundInFile($string, $file)
    {
        $fileHandle = fopen(self::getFileUrl($file), "r");
        while (!feof($fileHandle)) {
            if (trim($string) === trim(fgets($fileHandle))){
                return true;
            }
        }
        fclose($fileHandle);
        return false;
    }
}