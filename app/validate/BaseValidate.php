<?php


namespace App\validate;

use Lib\Session\Session;

/**
 * Class BaseValidate
 * @package App\validate
 */
class BaseValidate
{
    /**
     * @var
     */
    protected $message;

    /**
     * @var
     */
    protected $name;

    /**
     * @return mixed|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param bool $show
     */
    public function setSow($show = false)
    {
        Session::set($this->name, (string)$show);
    }

    /**
     * @return bool
     */
    public function getShow()
    {
        return (bool)Session::get($this->name);
    }

    /**
     *
     */
    public function hidden()
    {
        Session::remove($this->name);
    }
}