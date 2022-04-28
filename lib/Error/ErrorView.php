<?php


namespace Lib\Error;

use Lib\File\File;

/**
 * Class ErrorView
 * @package Lib\Error
 */
class ErrorView
{
    /**
     * @param $status
     * @param $statusText
     */
    public static function generate($status, $statusText)
    {
        echo "<style type='text/css'>";
        echo File::getContent(__DIR__ . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css');
        echo "</style>";
        require_once 'View' . DIRECTORY_SEPARATOR . 'error.php';

        die();
    }
}