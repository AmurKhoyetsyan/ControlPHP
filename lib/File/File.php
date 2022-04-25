<?php


namespace Lib\File;

/**
 * Class File
 * @package Lib\File
 */
class File
{
    /**
     * @param string $dir
     * @return bool
     */
    public static function isDir(string $dir)
    {
        return is_dir($dir);
    }

    /**
     * @param string $dir
     * @return array|bool|false
     */
    public static function scanDir(string $dir)
    {
        if (self::isDir($dir)) {
            return scandir($dir);
        }

        return false;
    }

    /**
     * @param string $dir
     * @return bool
     */
    public static function isFile(string $dir)
    {
        if (self::isDir($dir)) {
            return is_file($dir);
        }

        return false;
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function issetFile(string $path)
    {
        return file_exists($path);
    }

    /**
     * @param string $dir
     * @return bool
     */
    public static function createDirectory(string $dir)
    {
        if (self::isDir($dir)) {
            return true;
        }

        return mkdir($dir);
    }

    /**
     * @param string $path
     * @param $data
     * @return false|int
     */
    public static function createFile(string $path, $data)
    {
        $arrDir = explode(DIRECTORY_SEPARATOR, $path);
        $fileName = end($arrDir);
        array_pop($arrDir);
        $dir = implode(DIRECTORY_SEPARATOR, $arrDir);

        if (self::isDir($dir)) {
            return file_put_contents($dir . DIRECTORY_SEPARATOR . $fileName, $data);
        }

        $baseDir = basePath();
        $dir = str_replace($baseDir . DIRECTORY_SEPARATOR, '', $dir);
        $arrDir = explode(DIRECTORY_SEPARATOR, $dir);
        $dir = $baseDir . DIRECTORY_SEPARATOR;

        foreach ($arrDir as $dirItem) {
            self::createDirectory($dir .$dirItem);
            $dir .= $dirItem . DIRECTORY_SEPARATOR;
        }

        return file_put_contents($dir . DIRECTORY_SEPARATOR . $fileName, $data);
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function removeFile(string $path)
    {
        try {
            if (self::issetFile($path)) {
                return unlink($path);
            }

            return false;
        } catch (\Exception $err) {
            return false;
        }
    }

    /**
     * @param string $path
     * @return bool|false|string
     */
    public static function getContent(string $path)
    {
        if (self::issetFile($path)) {
            return file_get_contents($path);
        }

        return false;
    }
}