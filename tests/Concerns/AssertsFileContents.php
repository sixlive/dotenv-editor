<?php

namespace sixlive\DotenvEditor\Tests\Concerns;

trait AssertsFileContents
{
    /**
     * Asserts contents against a file path.
     *
     * @param  string  $contents
     * @param  string $path
     * @return void
     *
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    function assertFileContents($contents, $path)
    {
        $this->assertEquals($contents, file_get_contents($path));
    }
}
