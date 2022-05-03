<?php


namespace Lib\Request;

use Lib\Statuses\Statuses;

/**
 * Class Request
 * @package Lib\Request
 */
class Request
{
    use RequestData;

    /**
     * @param string $method
     * @param callable $callable
     * @param callable $generate
     */
    public static function issetMethod(string $method, callable $callable, callable $generate)
    {
        self::setMethod();

        if (strtolower($_SERVER['REQUEST_METHOD']) === strtolower($method)) {
            $callable();
            die;
        }

        $status = Statuses::HTTP_METHOD_NOT_ALLOWED;
        $statusText = Statuses::$statusTexts[$status];

        $generate($status, $statusText);
        die;
    }
}