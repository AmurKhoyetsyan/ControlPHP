<?php


namespace Lib\Request;

/**
 * Trait RequestData
 * @package Lib\Request
 */
trait RequestData
{
    /**
     * set method for request
     */
    protected static function setMethod()
    {
        if (!empty($_POST)) {
            if (isset($_POST['_method'])) {
                $_SERVER['REQUEST_METHOD'] = $_POST['_method'];
                unset($_POST['_method']);
            }
        }
    }

    /**
     * @return array
     */
    protected static function getFiles()
    {
        $data = !empty($_FILES) ? $_FILES : [];

        $files = [];

        foreach ($data as $item => $value) {
            if (!!$value['error']) {
                continue;
            }

            $files = array_merge($files, [$item => $value]);
        }

        return $files;
    }

    /**
     * @return array
     */
    public static function postRequest()
    {
        $data = !empty($_POST) ? $_POST : [];

        $files = self::getFiles();

        if (!empty($files)) {
            $data['_file'] = $files;
        }

        return $data;
    }

    /**
     * @return array
     */
    public static function getRequest()
    {
        if (!empty($_GET)) {
            array_shift($_GET);

            return $_GET;
        }

        return [];
    }
}