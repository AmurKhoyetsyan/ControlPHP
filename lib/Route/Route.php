<?php

namespace Lib\Route;

/**
 * Class Route
 * @package App\route
 */
class Route
{
    use Routing, MiddlewareCreator;

    /**
     * @param array $option
     * @param bool $first
     * @return string
     */
    protected static function addStringDataRoute(array $option = [], $first = true): string
    {
        $url = '';
        $count = 0;

        foreach ($option as $key => $value) {
            $start = $count === 0 && $first ? '?' : '&';
            $count++;
            $url .= $start . $key . '=' . (string)$value;
        }

        return $url;
    }

    /**
     * @param string $name
     * @param null $id
     * @return string
     */
    protected static function getRoute(string $name, $id = null): string
    {
        $urlPath = self::$register[$name]['route'];
        $url = $urlPath[0] === '/' ? $urlPath : '/' . implode('/', explode('.', $urlPath));

        if (!is_null($id)) {
            if (is_array($id)) {
                $url .= self::addStringDataRoute($id);
            } else {
                $url .= '?id=' . $id;
            }
        }

        return $url;
    }

    /**
     * @param string $name
     * @param null $id
     * @param array $option
     * @return string
     */
    public static function start(string $name, $id = null, $option = [])
    {
        $host = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'];
        return $host . self::getRoute($name, $id) . self::addStringDataRoute($option, is_null($id));
    }

    /**
     * @param string $name
     * @param null $id
     * @param array $option
     */
    public static function redirect(string $name, $id = null, $option = [])
    {
        return header('Location: ' . self::getRoute($name, $id) . self::addStringDataRoute($option, is_null($id)));
    }

    /**
     * @param string $routeName
     * @param $controller
     * @return Route
     */
    public static function get(string $routeName, $controller)
    {
        self::createDataRoute($routeName, $controller, 'GET');
        return new self;
    }

    /**
     * @param string $routeName
     * @param $controller
     * @return Route
     */
    public static function post(string $routeName, $controller)
    {
        self::createDataRoute($routeName, $controller, 'POST');
        return new self;
    }

    /**
     * @param string $routeName
     * @param $controller
     * @return Route
     */
    public static function put(string $routeName, $controller)
    {
        self::createDataRoute($routeName, $controller, 'PUT');
        return new self;
    }

    /**
     * @param string $routeName
     * @param $controller
     * @return Route
     */
    public static function destroy(string $routeName, $controller)
    {
        self::createDataRoute($routeName, $controller, 'DESTROY');
        return new self;
    }

    /**
     * @param $name
     */
    public function name($name)
    {
        self::createRegister($name);
    }

    /**
     * @param string $name
     * @param callable $callBack
     * @return Route
     * @throws \ReflectionException
     */
    public static function middleware(string $name, callable $callBack)
    {
        $callBack();

        self::closure_dump($callBack, $name);

        return new self;
    }

    /**
     * run routing
     */
    public static function run()
    {
        foreach (self::$register as $key => $value) {
            self::printView($value);
        }
    }
}