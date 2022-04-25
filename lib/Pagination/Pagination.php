<?php

namespace Lib\Pagination;
use App\db\DB;
use Lib\File\File;
use Lib\Pagination\Traits\PaginationItems;
use Lib\Pagination\Traits\PaginationFunctional;

/**
 * Class Pagination
 * @package Lib\Pagination
 */
class Pagination extends DB
{
    use PaginationFunctional, PaginationItems;

    /**
     * Pagination constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = $_SERVER["REQUEST_URI"];
        $this->method = $_GET;
    }

    /**
     * @param string[] $column
     * @return string
     */
    public function getContent($column = ['*'])
    {
        $column = (array)$column;

        return implode(', ', $column);
    }

    /**
     * get count and all pages
     */
    public function getPages()
    {
        $this->numElements = $this->getNum();

        $this->count = ceil($this->numElements / $this->limit);
        $this->pages = range(1, $this->count);
    }

    /**
     * @return string
     */
    protected function generateUrl()
    {
        $url = "";

        if (!empty($this->method)) {
            $count = 0;
            foreach ($this->method as $key => $value) {
                if ($key === 'page' || $key === 'path') {
                    continue;
                }

                if ($count === 0) {
                    $url .= "?";
                }

                if ($count > 0) {
                    $url .= "&";
                }

                $url .= "$key=$value";

                $count ++;
            }
        }

        return $url;
    }

    /**
     * @param $index
     * @param bool $rule
     * @return string
     */
    public function setUrl($index, $rule = false)
    {
        $url = $this->generateUrl();

        if (mb_strlen($url) === 0) {
            return "?page=" . ($rule ? $index : $this->pages[$index]);
        }

        return $url . "&page=" . ($rule ? $index : $this->pages[$index]);
    }

    /**
     * @return int
     */
    public function getLen()
    {
        return (int)$this->count;
    }

    /**
     * @return bool
     */
    public function issetPages()
    {
        return !empty($this->method) && isset($this->method["page"]);
    }

    /**
     * @return bool
     */
    public function show()
    {
        return $this->numElements > $this->limit;
    }

    /**
     * @param $pagination
     */
    public function create($pagination)
    {
        echo "<style type='text/css'>";
        echo File::getContent(__DIR__ . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'pagination.css');
        echo "</style>";
        require_once 'View' . DIRECTORY_SEPARATOR . 'pagination.php';
    }
}