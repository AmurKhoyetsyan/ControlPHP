<?php


namespace Lib\FileUpload;

use Lib\File\File;

/**
 * Class FileUpload
 * @package Lib\FileUpload
 */
class FileUpload
{
    /**
     * @param $file
     * @param $path
     * @return bool|string
     */
    public function upload($file, $path)
    {
        $name = uuid(20) . basename($file['name']);
        $fullPath = $path . $name;
        $check = getimagesize($file["tmp_name"]);

        if (!File::isDir($path)) {
            $baseDir = basePath();
            $dir = str_replace($baseDir . DIRECTORY_SEPARATOR, '', $path);
            $arrDir = explode(DIRECTORY_SEPARATOR, $dir);
            $dir = $baseDir . DIRECTORY_SEPARATOR;

            foreach ($arrDir as $dirItem) {
                File::createDirectory($dir .$dirItem);
                $dir .= $dirItem . DIRECTORY_SEPARATOR;
            }
        }

        if ($check) {
            $move = move_uploaded_file($file["tmp_name"], $fullPath);

            if (!$move) {
                return false;
            }
        } else {
            return false;
        }

        return $name;
    }
}