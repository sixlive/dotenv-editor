<?php

namespace sixlive\DotenvEditor\Support;

class Arr
{
    /**
     * @param  array  $array
     * @param  callable  $callback
     *
     * @return array
     */
    public static function mapWithKeys(array $array, callable $callback) : array
    {
        $newArray = [];

        foreach ($array as $key => $item) {
            $newArray[$key] = $callback($item, $key);
        }

        return $newArray;
    }

    public static function flatten($array)
    {
        $return = array();
        foreach ($array as $key => $value) {
            if (is_array($value)){
                $return = array_merge($return, static::flatten($value));
            } else {
                $return[$key] = $value;
            }
        }

        return $return;
    }
}
