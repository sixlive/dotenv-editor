<?php

namespace sixlive\DotenvEditor;

use SplFileObject;
use sixlive\DotenvEditor\Support\Arr;

class DotenvEditor
{
    protected $env = [];

    public function __construct()
    {
        //
    }

    public function load($path)
    {
        $this->envFile = new SplFileObject($path, 'r+');

        return $this;
    }

    public function set($key, $value)
    {
        $this->env[$key] = $value;

        return $this;
    }

    public function getEnv($key = '')
    {
        return isset($this->env[$key])
            ? $this->env[$key]
            : $this->env;
    }

    public function save()
    {
        $this->envFile->fwrite($this->format());

        return $this;
    }

    private function format()
    {
        $valuePairs = Arr::mapWithKeys($this->env, function ($item, $key) {
            return sprintf('%s=%s', $key, $item);
        });

        return implode("\n", $valuePairs);
    }
}
