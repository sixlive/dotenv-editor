<?php

namespace sixlive\DotenvEditor;

use SplFileObject;
use sixlive\DotenvEditor\Support\Arr;

class DotenvEditor
{
    protected $env = [];

    /**
     * @var \SplFileObject
     */
    protected $envFile;

    public function __construct()
    {
        //
    }

    public function load($path)
    {
        $this->envFile = new SplFileObject($path, 'r+');

        if ($this->envFile->getSize() > 0) {
            $z = explode("\n", $this->envFile->fread($this->envFile->getSize()));

            $zz = array_map(function ($line) {
                return explode('=', $line);
            }, $z);

            $zzz = array_map(function ($line) {
                if (count($line) === 2) {
                    return [$line[0] => $line[1]];
                }

                return $line[0];
            }, $zz);

            $this->env = array_merge($this->env, Arr::flatten($zzz));
        }

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

    public function addEmptyLine()
    {
        $this->env[] = '';

        return $this;
    }

    public function heading($heading)
    {
        if (!empty(end($this->env))) {
            $this->addEmptyLine();
        }

        $this->env[] = sprintf('# %s', $heading);

        return $this;
    }

    public function has($key)
    {
        return isset($this->env[$key]);
    }

    public function __destruct()
    {
        $this->envFile = '';
    }

    private function format()
    {
        $valuePairs = Arr::mapWithKeys($this->env, function ($item, $key) {
            return ! empty($item)  && ! is_integer($key)
                ? sprintf('%s=%s', $key, $item)
                : $item;
        });

        return implode("\n", $valuePairs);
    }
}
