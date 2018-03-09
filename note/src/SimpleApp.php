<?php

namespace Note;

use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;

class SimpleApp extends AppFactory
{

    /**
     * @return Container
     */
    protected function createContainer()
    {
        $loader = new ContainerLoader($this->tempDir, $this->env === App::DEVELOPMENT);
        $class = $loader->load('', function (Compiler $compiler) {

            foreach ($this->extensions as $name => $extension) {
                $extension = !is_object($extension) ? new $extension : $extension;
                $compiler->addExtension($name, $extension);
            }

            foreach ($this->configs as $config) {
                $compiler->loadConfig($config);
            }

            $compiler->addConfig($this->parameters);

        });

        return new $class;
    }

    /**
     * @return App
     */
    public function create()
    {
        $container = $this->createContainer();
        return new App($container);
    }

}
