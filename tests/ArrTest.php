<?php

namespace sixlive\DotenvEditor\Tests;

use PHPUnit\Framework\TestCase;
use sixlive\DotenvEditor\Support\Arr;

class ArrTest extends TestCase
{
    /** @test */
    public function it_will_map_with_keys()
    {
        $array = [
        'foo' => 'bar',
        'baz' => 'bax',
    ];

        $result = Arr::mapWithKeys($array, function ($item, $key) {
            return $item.'qux';
        });

        $this->assertEquals([
            'foo' => 'barqux',
            'baz' => 'baxqux',
        ], $result);
    }

    /** @test */
    public function arrays_can_be_flattened()
    {
        $array = [
            ['foo' => 'bar', 'baz' => ['bax' => 'qux']],
            'qoo' => 'qar',
        ];

        $this->assertEquals([
           'foo' => 'bar',
           'bax' => 'qux',
           'qoo' => 'qar',
       ], Arr::flatten($array));
    }
}
