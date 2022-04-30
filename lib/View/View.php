<?php


namespace Lib\View;

/**
 * Class View
 * @package Lib\View
 */
class View
{
    use Views;

    /**
     * @var
     */
    protected static $view;

    /**
     * @var
     */
    protected static $arguments;

    /**
     * @var
     */
    public $data;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->data = self::start();
    }

    /**
     * @param $viewName
     * @param $arguments
     * @return View
     */
    public static function show($viewName, $arguments)
    {
        self::$viewName = $viewName;
        self::$view = basePath() . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, explode('.', $viewName)) . '.php';
        self::$arguments = $arguments;
        return new self();
    }

    /**
     * @return array
     */
    protected static function start()
    {
        self::redFile();

        self::getIncludes();

        return [
            'arguments' => self::$arguments,
            'file' => self::useRegister() . self::$file
        ];
    }
}