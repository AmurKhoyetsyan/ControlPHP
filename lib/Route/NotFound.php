<?php


namespace Lib\Route;

use Lib\Error\ErrorView;

/**
 * Trait NotFound
 * @package Lib\Route
 */
trait NotFound
{
    /**
     * @param $status
     * @param $statusText
     */
    protected static function generateErrorView($status, $statusText)
    {
        $getPageNotFount = config('app');

        http_response_code($status);

        if (!is_null($getPageNotFount['not-found'])) {
            $view = view($getPageNotFount['not-found']);

            $uuid = uuid(50);

            $path = basePath() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $uuid . '.php';
                
            self::generateView($path, $view->data);
        }

        ErrorView::generate($status, $statusText);
    }
}