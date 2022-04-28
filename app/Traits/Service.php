<?php


namespace App\Traits;

/**
 * Trait Service
 * @package App\Traits
 */
trait Service
{
    /**
     * @param $item
     * @return string
     */
    protected function generateValue($item)
    {
        $val = "";

        foreach ($item as $key => $value) {
            $val .= $value . ' ';
        }

        return trim($val);
    }

    /**
     * @param $var
     * @return string
     */
    protected function isStringToString($var)
    {
        return is_string($var) ? "'$var'" : $var;
    }
}