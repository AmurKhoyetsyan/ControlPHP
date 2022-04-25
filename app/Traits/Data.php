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
    protected function postRequest()
    {
        $data = !empty($_POST) ? $_POST : [];
        $data['_file'] = !empty($_FILES) ? $_FILES : [];

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