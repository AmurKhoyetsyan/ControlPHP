<?php

namespace App\db;

/**
 * Class DB
 * @package db
 */
class DB
{
    /**
     * @var false|resource
     */
    protected static $connection;

    /**
     * @var bool
     */
    protected static $db;

    /**
     * DB constructor.
     */
    public function __construct()
    {
        self::$connection = mysqli_connect(env('DB_SERVER'), env('DB_USER'), env('DB_PASS')) or die(mysqli_error());
        self::$db = mysqli_select_db(self::$connection, env('DB_NAME'));
    }

    /* Transactions functions */

    /**
     * @return bool|resource
     */
    public static function beginTransaction()
    {
        $null = mysqli_query(self::$connection, "START TRANSACTION");
        return mysqli_query(self::$connection, "BEGIN");
    }

    /**
     * @return bool|resource
     */
    public static function commit()
    {
        return mysqli_query(self::$connection, "COMMIT");
    }

    /**
     * @return bool|resource
     */
    public static function rollback()
    {
        return mysqli_query(self::$connection, "ROLLBACK");
    }

    /**
     * @return false|resource
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    /**
     * @return bool
     */
    public static function getDB()
    {
        return self::$db;
    }
}