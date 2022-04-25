<?php


namespace Lib\Hash;

/**
 * Class Hash
 * @package Lib\Hash
 */
class Hash
{
    /**
     * @param string $string
     * @return false|string|null
     */
    public static function generate(string $string)
    {
        return password_hash($string, PASSWORD_DEFAULT);
    }

    /**
     * @param string $mbString
     * @param string $string
     * @return bool
     */
    public static function equal(string $mbString, string $string)
    {
        return password_verify($string, $mbString);
    }
}