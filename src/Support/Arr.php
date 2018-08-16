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
}
