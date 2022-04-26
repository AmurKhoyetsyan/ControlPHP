<?php


namespace App\Traits;

/**
 * Trait Data
 * @package App\Traits
 */
trait Data
{
    /**
     * @return array
     */
    protected function getFiles()
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
    protected function postRequest()
    {
        $data = !empty($_POST) ? $_POST : [];

        $files = $this->getFiles();

        if (!empty($files)) {
            $data['_file'] = $files;
        }

        return $data;
    }

    /**
     * @return array
     */
    protected function getRequest()
    {
        if (!empty($_GET)) {
            array_shift($_GET);

            return $_GET;
        }

        return [];
    }
}