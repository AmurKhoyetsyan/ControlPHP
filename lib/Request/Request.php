<?php


namespace Lib\Request;

use Lib\Route\Route;
use Lib\Statuses\Statuses;

/**
 * Class Request
 * @package Lib\Request
 */
class Request
{
    /**
     * @param string $method
     * @param callable $callable
     * @param callable $generate
     */
    public static function issetMethod(string $method, callable $callable, callable $generate)
    {
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