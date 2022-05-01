<?php


namespace Lib\View;

use Lib\File\File;

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
     * @return null
     */
    protected static function redFile()
    {
        if (!File::issetFile(self::$view)) {
            return null;
        }

        self::$file = File::getContent(self::$view);
    }

    /**
     * @param $str
     * @return bool|false|string
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
        $path = basePath() . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('.', $inc)) . '.php';


        if (!File::issetFile($path)) {
            return $content;
        }

        return File::getContent($path);
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
            foreach ($config[self::$viewName] as $item) {
                $start = strrpos($item, DIRECTORY_SEPARATOR);
                $len = strlen($item);
                $word = substr($item, $start + 1, $len - $start);
                $code .= "\n use " . $item . "; \n $" . lcfirst($word) . " = new $word(); \n";
            }
        }

        $code .= "?> \n";

        return $code;
    }
}