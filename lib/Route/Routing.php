<?php


namespace Lib\Route;

use App\db\Auth;
use Lib\File\File;

/**
 * Trait Routing
 * @package Lib\Route
 */
trait Routing
{
    /**
     * @var
     */
    protected static $routeData;

    /**
     * @var array
     */
    protected static $register = [];

    /**
     * @var
     */
    private static $uui;

    /**
     * @return array
     */
    public static function getRegister()
    {
        return self::$register;
    }

    /**
     * @param $name
     */
    protected static function createRegister($name)
    {
        foreach (self::$register as $route => $item) {
            if (trim(strtolower($item['route'])) === trim(strtolower(self::$routeData['route']))) {
                unset(self::$register[$route]);
                self::$register[$name] = self::$routeData;
            }
        }
    }

    /**
     * @return mixed
     */
    protected static function getRouteUrl()
    {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
    }

    /**
     * @param string $routeName
     * @return bool
     */
    protected static function isRoute(string $routeName)
    {
        return self::getRouteUrl() === $routeName;
    }

    /**
     * @param $routeName
     * @param $controller
     * @param string $method
     * @return bool
     */
    protected static function createDataRoute($routeName, $controller, $method = 'GET')
    {
        self::$routeData = [
            'method' => $method,
            'route' => $routeName,
        ];

        $controllerOrFunction = [];

        if (is_array($controller)) {
            $controllerOrFunction['controller'] = $controller[0];
            $controllerOrFunction['function'] = $controller[1];
        } else {
            $controllerOrFunction['controller'] = false;
            $controllerOrFunction['function'] = $controller;
        }

        self::$routeData = array_merge(self::$routeData, $controllerOrFunction);

        if (count(self::$register) === 0) {
            self::$register[] = self::$routeData;
            return true;
        }

        foreach (self::$register as $route => $item) {
            if (trim(strtolower($item['route'])) !== trim(strtolower($routeName))) {
                self::$register[] = self::$routeData;
            }
        }
    }

    /**
     * @param $patForGenerateNewPhpFile
     * @param $dataForGenerateNewPhpFile
     */
    protected static function generateView($patForGenerateNewPhpFile, $dataForGenerateNewPhpFile)
    {
        File::createFile($patForGenerateNewPhpFile, $dataForGenerateNewPhpFile['file']);

        $argumentsForGenerateNewPhpFile = $dataForGenerateNewPhpFile['arguments'];

        if (!is_null($argumentsForGenerateNewPhpFile)) {
            foreach ($argumentsForGenerateNewPhpFile as $key => $value) {
                $$key = $value;
            }
        }

        require_once $patForGenerateNewPhpFile;

        File::removeFile($patForGenerateNewPhpFile);

        die;
    }

    /**
     * @param $value
     */
    public static function viewShow($value)
    {
        $data = null;
        if (is_bool($value['controller'])) {
            $data = call_user_func($value['function'])->data;
        } else {
            $class = new $value['controller'];
            $function = $value['function'];
            $data = call_user_func(array($class, $function))->data;
        }

        $uuid = Auth::uuid(50);

        $path = basePath() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $uuid . '.php';

        self::generateView($path, $data);
    }

    /**
     * @param $value
     * @return bool
     */
    protected static function printView($value)
    {
        if (self::isRoute($value['route'])) {
            if (isset($value['middleware'])) {
                $config = config('middleware_config');

                if (isset($config[$value['middleware']])) {
                    $runner = new $config[$value['middleware']]();
                    if ($runner->run()) {
                        self::viewShow($value);
                        return true;
                    }

                    $runner->redirect();
                    return false;
                }

                return false;
            }

            self::viewShow($value);

            return true;
        }
    }
}