<?php

namespace sixlive\DotenvEditor;

use sixlive\DotenvEditor\Support\Arr;

class DotenvEditor
{
    /**
     * @var array
     */
    protected $env = [];

    /**
     * @var \sixlive\DotenvEditor\EnvFile
     */
    protected $envFile;

    /**
     * Load an values from an env file.
     *
     * @param  string  $path
     *
     * @return self
     */
    public function load($path)
    {
        $this->envFile = new EnvFile($path);

        if ($this->envFile->isNotEmpty()) {
            $this->env = array_merge($this->env, $this->envFile->toArray());
        }

        return $this;
    }

    /**
     * Set a key value pair for the env file.
     *
     * @param  string  $key
     * @param  string  $value
     *
     * @return self
     */
    public function set($key, $value)
    {
        $this->env[$key] = $value;

        return $this;
    }

    /**
     * Get all of the env values or a single value by key.
     *
     * @param  string  $key
     *
     * @return array|string
     */
    public function getEnv($key = '')
    {
        return isset($this->env[$key])
            ? $this->env[$key]
            : $this->env;
    }

    /**
     * Save the current representation to disk. If no path is specifed and
     * a file was loaded, it will overwrite the file that was loaded.
     *
     * @param  string  $path
     *
     * @return self
     */
    public function save($path = '')
    {
        if (empty($path) && $this->envFile) {
            $this->envFile->write($this->format());
        } else {
            file_put_contents($path, $this->format());
        }

        return $this;
    }

    /**
     * Add an empty line to the config.
     *
     * @return self
     */
    public function addEmptyLine()
    {
        $this->env[] = '';

        return $this;
    }

    /**
     * Add a comment heading. If there is a line before it, it will add an empty
     * line before the heading.
     *
     * @param  string  $heading
     *
     * @return self
     */
    public function heading($heading)
    {
        if (! empty(end($this->env))) {
            $this->addEmptyLine();
        }

        $this->env[] = sprintf('# %s', $heading);

        return $this;
    }

    /**
     * Check if a key is defined in the env.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->env[$key]);
    }

    public function __destruct()
    {
        if ($this->envFile) {
            $this->envFile->close();
        }
    }

    /**
     * Format the config file in key=value pairs.
     *
     * @return string
     */
    private function format()
    {
        $valuePairs = Arr::mapWithKeys($this->env, function ($item, $key) {
            return is_string($key)
                ? sprintf('%s=%s', $key, $item)
                : $item;
        });

        return implode("\n", $valuePairs);
    }
}
