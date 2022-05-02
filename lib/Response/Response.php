<?php


namespace Lib\Response;

/**
 * Class Response
 * @package Lib\Response
 */
class Response
{
    /**
     * @var mixed
     */
    protected static $data;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        header('Content-type: text/json; charset=utf-8');

        print_r(self::$data);
        die;
    }

    /**
     * @param $data
     * @param bool $json
     * @return Response
     */
    public static function response($data, $json = true)
    {
        self::$data = $json ? json_encode($data, true) : $data;
        return new self();
    }
}