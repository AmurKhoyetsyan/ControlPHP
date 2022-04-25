<?php

namespace App\db;

/**
 * Class BaseModel
 * @package model
 */
abstract class BaseModel
{

    /**
     * @param $column
     * @return mixed
     */
    abstract public function get($column);

    /**
     * @param $id
     * @param $column
     * @return mixed
     */
    abstract public function find($id, $column);

    /**
     * @param $data
     * @return mixed
     */
    abstract public function create($data);
}