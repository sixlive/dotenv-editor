<?php

namespace sixlive\DotenvEditor\Tests;

use PHPUnit\Framework\TestCase;
use sixlive\DotenvEditor\DotenvEditor;

class DotenvEditorTest extends TestCase
{
    use Concerns\AssertsFileContents;

    protected $path = __DIR__.'/tmp/env';

    public function setUp()
    {
        touch($this->path);
    }

    public function tearDown()
    {
        array_map('unlink', glob(__DIR__.'/tmp/*'));
    }

    /** @test */
    public function a_config_value_can_be_set()
    {
        $editor = new DotenvEditor;

        $editor->set('EXAMPLE_CONFIG', 'foo');

        $this->assertEquals(
           'foo',
           $editor->getEnv('EXAMPLE_CONFIG')
       );
    }

    /** @test */
    public function all_config_values_can_be_retrieved()
    {
        $editor = new DotenvEditor;

        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->set('EXAMPLE_CONFIG_2', 'bar');

        $this->assertEquals(
           ['EXAMPLE_CONFIG' => 'foo', 'EXAMPLE_CONFIG_2' => 'bar'],
           $editor->getEnv()
       );
    }

    /** @test */
    public function config_values_can_be_saved()
    {
        $editor = new DotenvEditor;

        $editor->load($this->path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->save();

        $this->assertFileContents('EXAMPLE_CONFIG=foo', $this->path);
    }

    /** @test */
    public function config_values_can_be_saved_to_a_new_path()
    {
        $newPath = __DIR__.'/tmp/env-new';
        $editor = new DotenvEditor;

        $editor->load($this->path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->save($newPath);

        $this->assertFileContents('EXAMPLE_CONFIG=foo', $newPath);
    }

    /** @test */
    public function multiple_config_values_can_be_saved()
    {
        $editor = new DotenvEditor;

        $editor->load($this->path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->set('EXAMPLE_CONFIG_2', 'bar');
        $editor->save();

        $this->assertFileContents(
            "EXAMPLE_CONFIG=foo\nEXAMPLE_CONFIG_2=bar",
            $this->path
        );
    }

    /** @test */
    public function line_breaks_can_be_added()
    {
        $editor = new DotenvEditor;

        $editor->load($this->path);
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->addEmptyLine();
        $editor->set('EXAMPLE_CONFIG_2', 'bar');
        $editor->save();

        $this->assertFileContents(
            "EXAMPLE_CONFIG=foo\n\nEXAMPLE_CONFIG_2=bar",
            $this->path
        );
    }

    /** @test */
    public function headings_can_be_added()
    {
        $editor = new DotenvEditor;

        $editor->load($this->path);
        $editor->heading('Examples');
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->save();

        $this->assertFileContents(
            "# Examples\nEXAMPLE_CONFIG=foo",
            $this->path
        );
    }

    /** @test */
    public function headings_get_added_with_a_new_line_after_a_non_blank_entry()
    {
        $editor = new DotenvEditor;

        $editor->load($this->path);
        $editor->set('APP_KEY', 'bar');
        $editor->heading('Examples');
        $editor->set('EXAMPLE_CONFIG', 'foo');
        $editor->save();

        $this->assertFileContents(
            "APP_KEY=bar\n\n# Examples\nEXAMPLE_CONFIG=foo",
            $this->path
        );
    }

    /** @test */
    public function values_from_files_are_imported_on_load()
    {
        $editor = new DotenvEditor;

        $editor->load(__DIR__.'/Fixtures/env-example');

        $this->assertEquals([
            'EXAMPLE' => 'bar',
            0 => '',
            1 => '# Section',
            'EXAMPLE_2' => 'bar',
            2 => '',
        ], $editor->getEnv());
    }

    /** @test */
    public function keys_can_be_checked_for()
    {
        $editor = new DotenvEditor;
        $editor->load(__DIR__.'/Fixtures/env-example');

        $this->assertTrue($editor->has('EXAMPLE_2'));
    }

    /** @test */
    public function configuration_values_can_be_merge_with_an_existing_config()
    {
        copy(__DIR__.'/Fixtures/env-example', $this->path);
        $editor = new DotenvEditor;
        $editor->load($this->path);

        $editor->heading('Foo');
        $editor->set('FOO', 'bar');
        $editor->save();

        $this->assertFileContents(
            "EXAMPLE=bar\n\n# Section\nEXAMPLE_2=bar\n\n# Foo\nFOO=bar",
            $this->path
        );
    }

    /** @test */
    public function leaves_blank_settings_as_they_were()
    {
        $fixturePath = __DIR__.'/Fixtures/env-laravel';
        copy($fixturePath, $this->path);

        $editor = new DotenvEditor;
        $editor->load($this->path);

        $editor->set('FOO', 'bar');
        $editor->save();

        $this->assertFileContents(
            file_get_contents($fixturePath)."\nFOO=bar",
            $this->path
        );
    }
}
