<?php

namespace Lib\Statuses;

/**
 * Class Statuses
 * @package Lib\Statuses
 */
class Statuses
{
    const HTTP_OK = 200;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * @var string[]
     */
    public static $statusTexts = [
        200 => 'OK',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    ];

    /**
     * @var string[]
     */
    public static $errorViewName = [
        404 => 'not-found',
        405 => 'not-allowed',
        500 => 'server-error'
    ];
}