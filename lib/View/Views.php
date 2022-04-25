<?php


namespace Lib\View;

/**
 * Trait Views
 * @package Lib\View
 */
trait Views
{
    /**
     * @var
     */
    protected static $viewName;

    /**
     * @var
     */
    protected static $file;

    /**
     * @return bool
     */
    protected static function issetFile()
    {
        return file_exists(self::$view);
    }

    /**
     * @return null
     */
    protected static function redFile()
    {
        if (!self::issetFile()) {
            return null;
        }

        self::$file = file_get_contents(self::$view);
    }

    /**
     * @param $str
     * @return false|string
     */
    protected static function getContentIncludes($str)
    {
        $start = strpos($str, '\'');
        $end = strrpos($str, '\'');

        $content = '';

        if ($start === false || $end === false) {
            return $content;
        }

        if ($start === false && $end === false) {
            $start = strpos($str, '"');
            $end = strrpos($str, '"');
        }

        $inc = substr($str, $start + 1, $end - $start - 1);
        $inc = trim($inc);
        $path = basePath() . DIRECTORY_SEPARATOR . 'resurces' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('.', $inc)) . '.php';


        if (!file_exists($path)) {
            return $content;
        }

        return file_get_contents($path);
    }

    /**
     * @return mixed
     */
    protected static function getIncludes()
    {
        $findStart = '@includes(';
        $findEnd = ')';

        $start = strpos(self::$file, $findStart);
        $end = false;

        if ($start !== false) {
            $end = strpos(self::$file, $findEnd, $start);
        }

        if ($start === false && $end === false) {
            return self::$file;
        }

        if ($start === false || $end === false) {
            return self::$file;
        }

        $inc = substr(self::$file, $start, $end - $start + 1);
        $includeContent = self::getContentIncludes($inc);
        self::$file = str_replace($inc, $includeContent, self::$file);

        return self::getIncludes();
    }

    /**
     * @return string
     */
    protected static function useRegister()
    {
        $config = config('register');
        $code = '<?php ';

        if (isset($config[self::$viewName])) {
            $start = strrpos($config[self::$viewName], DIRECTORY_SEPARATOR);
            $len = strlen($config[self::$viewName]);
            $word = substr($config[self::$viewName], $start + 1, $len - $start);
            $code .= "\n use " . $config[self::$viewName] . "; \n $" . lcfirst($word) . " = new $word(); \n";
        }

        $code .= "?> \n";

        return $code;
    }
}