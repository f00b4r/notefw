<?php

namespace Note;

use Nette\Bridges\HttpDI\HttpExtension;
use Nette\DI\Container;
use Note\DI\NoteExtension;

abstract class AppFactory
{

    /** @var array */
    protected $extensions = [
        // nette
        'http' => HttpExtension::class,
        // note
        'note' => NoteExtension::class,
    ];

    /** @var string */
    protected $env = Environment::PRODUCTION;

    /** @var array */
    protected $parameters = [];

    /** @var array */
    protected $configs = [];

    /** @var string */
    protected $tempDir;

    /**
     * @param string $tempDir
     */
    public function setTempDir($tempDir)
    {
        $this->tempDir = $tempDir;
    }

    /**
     * @param string $mode
     */
    public function setEnv($mode)
    {
        $this->env = $mode;
    }

    /**
     * @param string $name
     * @param string $extension
     */
    public function addExtension($name, $extension)
    {
        $this->extensions[$name] = $extension;
    }

    /**
     * @param string $config
     */
    public function addConfig($config)
    {
        $this->configs[] = $config;
    }


    /**
     * @param string $config
     */
    public function setParameters(array $params)
    {
        $this->parameters = $params;
    }

    /**
     * @return Container
     */
    abstract protected function createContainer();

    /**
     * @return App
     */
    abstract public function create();

}
