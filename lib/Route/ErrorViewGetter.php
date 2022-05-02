<?php

namespace Lib\Route;

use Lib\Error\ErrorView;
use Lib\Route\Route;
use Lib\Statuses\Statuses;

/**
 * Trait ErrorViewGetter
 * @package Lib\Route
 */
trait ErrorViewGetter
{
    /**
     * @param $status
     * @param $statusText
     */
    protected static function generateErrorView($status, $statusText)
    {
        $getPageNotFount = config('app');

        http_response_code($status);

        $viewName = Statuses::$errorViewName[$status];

        if (isset($getPageNotFount[$viewName]) && !is_null($getPageNotFount[$viewName])) {
            $view = view($getPageNotFount[$viewName], [
                'status' => $status,
                'statusText' => $statusText
            ]);

            $uuid = uuid(50);

            $path = basePath() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $uuid . '.php';
                
            self::generateView($path, $view->data);
        }

        ErrorView::generate($status, $statusText);
    }
}