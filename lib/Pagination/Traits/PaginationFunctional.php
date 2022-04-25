<?php

namespace Lib\Pagination\Traits;

/**
 * Trait PaginationFunctional
 * @package Lib\Pagination\Traits
 */
trait PaginationFunctional
{
    /**
     * @var string
     */
    protected $unique = 'id';

    /**
     * @var array
     */
    protected $pages = [];

    /**
     * @var int
     */
    protected $marker = 4;

    /**
     * @var int
     */
    protected $limit = 20;

    /**
     * @var float|int
     */
    protected $page = 0;

    /**
     * @var int
     */
    protected $numElements = 0;

    /**
     * @var int
     */
    protected $thisPage = 1;

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var string
     */
    protected $option = "";

    /**
     * @var bool
     */
    public $prev = false;

    /**
     * @var bool
     */
    public $next = true;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var array
     */
    protected $method = [];

    /**
     * @return int
     */
    protected function getNum()
    {
        $sql = "SELECT $this->unique FROM `$this->table` $this->option";

        $query = mysqli_query(self::$connection, $sql);

        $date = mysqli_fetch_all($query, MYSQLI_NUM);

        return count($date);
    }

    /**
     * @param string $table
     * @param string[] $columns
     * @param string $order
     * @param int $page
     * @param int $limit
     * @param string $option
     * @return array
     */
    public function getPagination($table = '', $columns = ['*'], $order = 'ASC', $page = 1, $limit = 10, $option = "")
    {
        $this->table = $table;
        $this->limit = $limit;
        $this->option = $option;
        $this->page = (($page * $limit) - $limit);

        $this->getPages();

        $content = $this->getContent($columns);

        $sql = "SELECT $content FROM `$this->table` $this->option ORDER BY id $order LIMIT $this->limit OFFSET $this->page";

        $query = mysqli_query(self::$connection, $sql);

        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    /**
     * @param int $val
     */
    public function setMarker(int $val)
    {
        $this->marker = $val;
    }

    /**
     * @return int
     */
    public function getMarker()
    {
        return (int)$this->marker;
    }

    /**
     * @param $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }

    /**
     * @return int
     */
    public function thisPage()
    {
        if (!empty($this->method) && isset($this->method["page"])) {
            return (int)$this->method["page"];
        } else {
            return 1;
        }
    }
}