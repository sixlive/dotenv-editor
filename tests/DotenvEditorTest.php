<?php

namespace sixlive\DotenvEditor\Tests;

use PHPUnit\Framework\TestCase;
use sixlive\DotenvEditor\DotenvEditor;

class DotenvEditorTest extends TestCase
{
    use Concerns\AssertsFileContents;

    protected $path = __DIR__.'/tmp/env';

    function setUp()
    {
        touch($this->path);
    }

    public function tearDown()
    {
        // array_map('unlink', glob(__DIR__.'/tmp/*'));
        unlink($this->path);
    }

    /** @test */
    public function a_config_value_can_be_set()
    {
        $editor = new DotenvEditor();

        $editor->set('EXAMPLE_CONFIG', 'foo');

        $this->assertEquals(
           'foo',
           $editor->getEnv('EXAMPLE_CONFIG')
       );
    }

    /** @test */
    public function all_config_values_can_be_retrieved()
    {
        $editor = new DotenvEditor();

        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->set('EXAMPLE_CONFIG_2', 'bar');

        $this->assertEquals(
           ['EXAMPLE_CONFIG' => 'foo', 'EXAMPLE_CONFIG_2' => 'bar'],
           $editor->getEnv()
       );
    }

    /** @test */
    function config_values_can_be_saved()
    {
        $editor = new DotenvEditor();

        $editor->load($this->path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->save();

        $this->assertFileContents('EXAMPLE_CONFIG=foo', $this->path);
    }

    /** @test */
    function multiple_config_values_can_be_saved()
    {
        $editor = new DotenvEditor();

        $editor->load($this->path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->set('EXAMPLE_CONFIG_2', 'bar');
        $editor->save();

        $this->assertEquals(
            "EXAMPLE_CONFIG=foo\nEXAMPLE_CONFIG_2=bar",
            file_get_contents($this->path)
        );
    }

    /** @test */
    function line_breaks_can_be_added()
    {
        $editor = new DotenvEditor();

        $editor->load($this->path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->addEmptyLine();
        $editor->set('EXAMPLE_CONFIG_2', 'bar');
        $editor->save();

        $this->assertEquals(
            "EXAMPLE_CONFIG=foo\n\nEXAMPLE_CONFIG_2=bar",
            file_get_contents($this->path)
        );
    }

    /** @test */
    function headings_can_be_added()
    {
        $editor = new DotenvEditor();

        $editor->load($this->path);
        $editor->heading('Examples');
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->save();

        $this->assertEquals(
            "\n# Examples\nEXAMPLE_CONFIG=foo",
            file_get_contents($this->path)
        );
    }

    // /** @test */
    // function keys_can_be_checked_for()
    // {

    // }
}
