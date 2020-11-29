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
    public static function mapWithKeys(array $array, callable $callback): array
    {
        $newArray = [];

        foreach ($array as $key => $item) {
            $newArray[$key] = $callback($item, $key);
        }

        return $newArray;
    }

    /**
     * Flatten a multidimensional array.
     *
     * @param  array  $array
     *
     * @return array
     */
    public static function flatten($array)
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $newArray = array_merge($newArray, static::flatten($value));
            } else {
                $newArray[$key] = $value;
            }
        }

        return $newArray;
    }
}
