<?php

namespace Lib\Session;

/**
 * Class Session
 * @package Lib\Session
 */
class Session
{
    public static function runSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
    /**
     * @param string $key
     * @param null $data
     * @return bool
     */
    public static function issetSession(string $key, $data = null)
    {
        self::runSession();
        if (!is_null($data)) {
            return isset($_SESSION[$key]) || $_SESSION[$key] === $data;
        }

        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @param $value
     */
    public static function set(string $key, $value)
    {
        self::runSession();
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        self::runSession();
        if (self::issetSession($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * @param string $key
     */
    public static function remove(string $key)
    {
        self::runSession();
        if (self::issetSession($key)) {
            unset($_SESSION[$key]);
        }
    }
}