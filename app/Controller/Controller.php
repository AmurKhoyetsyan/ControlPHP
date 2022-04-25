<?php


namespace App\Controller;

use App\Traits\Data;

/**
 * Class Controller
 * @package App\Controller
 */
class Controller
{
    use Data;

    /**
     * @var
     */
    protected $baseService;

    /**
     * @var
     */
    protected $baseValidate;
}