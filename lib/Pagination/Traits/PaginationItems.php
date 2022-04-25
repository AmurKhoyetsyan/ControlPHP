<?php

namespace Lib\Pagination\Traits;

/**
 * Trait PaginationItems
 * @package Lib\Pagination\Traits
 */
trait PaginationItems
{
    /**
     * @return string
     */
    public function next()
    {
        $url = $this->generateUrl();

        if (!empty($this->method) && isset($this->method["page"])) {
            $page = (((int)$this->method["page"]) + $this->thisPage);
            $page = $page > $this->count ? $this->count : $page;
            return mb_strlen($url) === 0 ? "?page=" . $page : $url . "&page=" . $page;
        } else {
            return $this->setUrl(2, true);
        }
    }

    /**
     * @return string
     */
    public function prev()
    {
        $url = $this->generateUrl();

        if (!empty($this->method) && isset($this->method["page"])) {
            $page = (((int)$this->method["page"]) - $this->thisPage);
            $page = $page < 1 ? 1 : $page;
            return mb_strlen($url) === 0 ? "?page=" . $page : $url . "&page=" . $page;
        } else {
            return $this->setUrl(1, true);
        }
    }

    /**
     * @return bool
     */
    public function nextActive()
    {
        if (!empty($this->method) && isset($this->method["page"])) {
            return ((int)$this->method["page"]) < $this->count;
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function prevActive()
    {
        if (!empty($this->method) && isset($this->method["page"])) {
            return ((int)$this->method["page"]) > 1;
        } else {
            return false;
        }
    }

    /**
     * @param $index
     * @return bool
     */
    public function itemActive($index)
    {
        if (!empty($this->method) && isset($this->method["page"])) {
            return ((int)$this->method["page"]) === ((int)$this->pages[$index]);
        } else {
            return ((int)$this->pages[$index]) === 1;
        }
    }

    /**
     * @param $index
     * @return mixed
     */
    public function getItemNumber($index)
    {
        return $this->pages[$index];
    }
}