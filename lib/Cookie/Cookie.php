<?php

namespace Lib\Cookie;

/**
 * Class Cookie
 * @package Lib\Cookie
 */
class Cookie
{
    /**
     * @param $sec
     * @return int
     */
    protected static function time($sec)
    {
        return time() + $sec;
    }

    /**
     * @param string $cookie_name
     * @param $cookie_value
     * @param int $time
     * @param string $route
     */
    public static function setCookie(string $cookie_name, $cookie_value, $route = '/', $time = 86400)
    {
        setcookie($cookie_name, $cookie_value,  self::time($time), $route);
    }

    /**
     * @param string $cookie_name
     * @return bool
     */
    public static function issetCookie(string $cookie_name)
    {
        if(isset($_COOKIE[$cookie_name])) {
            return true;
        }

        return false;
    }

    /**
     * @param string $cookie_name
     * @return mixed|null
     */
    public static function getCookie(string $cookie_name)
    {
        if (self::issetCookie($cookie_name)) {
            return $_COOKIE[$cookie_name];
        }

        return null;
    }

    /**
     * @param string $cookie_name
     * @param string $route
     */
    public static function removeCookie(string $cookie_name, $route = '/')
    {
        if (self::issetCookie($cookie_name)) {
            setcookie($cookie_name, null, self::time(-3600), $route);
        }
    }
}