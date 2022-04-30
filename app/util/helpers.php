<?php

use Lib\Route\Route;
use Lib\View\View;
use Lib\Response\Response;

if (!function_exists('basePath')) {
    /**
     * @return string
     */
    function basePath(): string
    {
        return dirname(dirname(__DIR__));
    }
}

if (!function_exists('url')) {
    /**
     * @param string $path
     * @return string
     */
    function url(string $path = ''): string
    {
        return $_SERVER['HTTP_X_FORWARDED_PROTO'] . ':' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $_SERVER['HTTP_HOST'] . $path;
    }
}

if (!function_exists('env')) {
    /**
     * @param null $keyItem
     * @param null $path
     * @return array|bool|mixed|string
     */
    function env($keyItem = null, $path = null)
    {
        $filePath = $path === null ? basePath() . DIRECTORY_SEPARATOR . '.env' : $path;

        $envArray = [];

        if (file_exists($filePath)) {
            $file = file_get_contents($filePath);

            $arr = explode("\n", $file);

            foreach ($arr as $item => $value) {
                if (strpos($value, '#') !== false) {
                    return false;
                }

                $equalPosition = strpos($value, '=');

                if ($equalPosition === false) {
                    return false;
                }

                $key = substr($value, 0, $equalPosition);
                $value = substr($value, $equalPosition + 1, strlen($value));

                $envArray[trim($key)] = trim($value);
            }
        }

        return $keyItem === null ? $envArray : $envArray[$keyItem];
    }
}

if (!function_exists('route')) {
    /**
     * @param String $name
     * @param null $id
     * @param array $option
     * @return string
     */
    function route(String $name, $id = null, $option = [])
    {
        return Route::start($name, $id, $option);
    }
}

if (!function_exists('redirect')) {
    /**
     * @param String $name
     * @param null $id
     * @param array $option
     */
    function redirect(String $name, $id = null, $option = [])
    {
        return Route::redirect($name, $id, $option);
    }
}

if (!function_exists('config')) {
    /**
     * @param string $path
     * @return array|bool
     */
    function config(string $path)
    {
        $path = basePath() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('.', $path)) . '.php';
        $file = [];

        if (file_exists($path)) {
            try {
                return json_decode(json_encode(require_once $path, true), true);
            } catch (Exception $exception) {
                return $file;
            }
        }

        return $file;
    }
}

if (!function_exists('dd')) {
    /**
     * @param mixed ...$args
     */
    function dd(...$args)
    {
        $count = count($args);
        echo '<pre style="background-color: #1F1F1F; color: #FFFFFF; padding: 0.5rem;">';
        for ($i = 0; $i < $count; $i++) {
            echo '<div style="padding-top: 5px; padding-bottom: 5px">';
            var_dump($args[$i]);
            echo '</div>';
        }
        echo '</pre>';
        die;
    }
}

if (!function_exists('view')) {
    /**
     * @param $viewName
     * @param null $arguments
     * @return View
     */
    function view($viewName, $arguments = null): View
    {
        return View::show($viewName, $arguments);
    }
}

if (!function_exists('response')) {
    /**
     * @param $data
     * @param bool $json
     * @return Response
     */
    function response($data, $json = true): Response
    {
        return Response::response($data, $json);
    }
}

if (!function_exists('includes')) {
    /**
     * @param $path
     * @param bool $rule
     */
    function includes($path, $rule = false)
    {
        include_once $rule ? $path : (basePath() . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR .'view' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('.', $path)) . '.php');
    }
}

if (!function_exists('uuid')) {
    /**
     * @param int $len
     * @param string $str
     * @return string
     */
    function uuid(int $len = 10, string $str = ''): string
    {
        $str .= uniqid();

        if (mb_strlen($str) > $len) {
            return mb_substr($str, 0, $len);
        }

        return uuid($len, $str);
    }
}