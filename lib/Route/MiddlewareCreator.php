<?php


namespace Lib\Route;

use ReflectionFunction;
use Closure;
use ReflectionException;

/**
 * Trait MiddlewareCreator
 * @package Lib\Route
 */
trait MiddlewareCreator
{
    /**
     * @var
     */
    protected static $middleware;

    /**
     * @param string $equal
     * @param $middleware
     */
    protected static function replaceRegister(string $equal, $middleware)
    {
        foreach (self::$register as $route => $item) {
            if (trim(strtolower($item['route'])) === trim(strtolower($equal))) {
                self::$register[$route]['middleware'] = $middleware;
            }
        }
    }

    /**
     * @param string $line
     * @param $middleware
     */
    protected static function replaceRouteMiddleware(string $line, $middleware)
    {
        $startPos = mb_strpos($line, '(\'');

        if ($startPos !== false) {
            $endPos = mb_strpos($line, '\'', $startPos + 2);
            $routeName = mb_substr($line, $startPos + 2, $endPos - $startPos - 2);

            self::replaceRegister($routeName, $middleware);
        }
    }

    /**
     * @param Closure $closure
     * @param $middleware
     * @throws ReflectionException
     */
    protected static function closure_dump(Closure $closure, $middleware)
    {
        $reflectionFunction = new ReflectionFunction($closure);
        $params = [];

        foreach ($reflectionFunction->getParameters() as $param) {
            $string = '';
            if ($param->isArray()) {
                $string .= 'array ';
            } else if ($param->getClass()) {
                $string .= $param->getClass()->name . ' ';
            }
            if ($param->isPassedByReference()) {
                $string .= '&';
            }
            $string .= '$' . $param->name;
            if ($param->isOptional()) {
                $string .= ' = ' . var_export($param->getDefaultValue(), TRUE);
            }
            $params [] = $string;
        }

        $lines = file($reflectionFunction->getFileName());

        for ($i = $reflectionFunction->getStartLine(); $i < $reflectionFunction->getEndLine(); $i++) {
            self::replaceRouteMiddleware($lines[$i], $middleware);
        }
    }
}