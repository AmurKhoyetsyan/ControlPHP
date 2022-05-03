<?php

namespace App\Controller;

use Lib\Request\Request;

/**
 * Class Controller
 * @package App\Controller
 */
class Controller extends Request
{
    /**
     * @var
     */
    protected $baseModel;

    /**
     * @var
     */
    protected $baseService;

    /**
     * @var
     */
    protected $baseValidate;
}