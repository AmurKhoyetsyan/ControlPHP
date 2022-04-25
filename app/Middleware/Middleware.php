<?php


namespace App\Middleware;

/**
 * Interface Middleware
 * @package App\Middleware
 */
interface Middleware
{
    /**
     * @return mixed
     */
    public function run();

    /**
     * @return mixed
     */
    public function redirect();
}