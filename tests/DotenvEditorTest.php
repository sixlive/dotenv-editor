<?php

namespace sixlive\DotenvEditor\Tests;

use PHPUnit\Framework\TestCase;
use sixlive\DotenvEditor\DotenvEditor;

class DotenvEditorTest extends TestCase
{
    public function tearDown()
    {
        array_map('unlink', glob(__DIR__.'/tmp/*'));
    }

    /** @test */
    public function it_can_set_a_config_value()
    {
        $editor = new DotenvEditor();

        $editor->set('EXAMPLE_CONFIG', 'foo');

        $this->assertEquals(
           'foo',
           $editor->getEnv('EXAMPLE_CONFIG')
       );
    }

    /** @test */
    public function it_can_save_the_config_value_to_a_file()
    {
        $path = __DIR__.'/tmp/env';
        touch($path);

        $editor = new DotenvEditor();

        $editor->load($path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->save();

        $this->assertEquals('EXAMPLE_CONFIG=foo', file_get_contents($path));
    }
}
