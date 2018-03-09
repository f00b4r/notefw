<?php

namespace Note\Extra\View\Latte\DI;

use Latte\Compiler;
use Latte\Engine;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\CompilerExtension;

class LatteExtension extends CompilerExtension
{

    /** @var array */
    protected $defaults = [
        'tempDir' => '%app.temp%',
        'debugMode' => '%app.debug%',
    ];

    public function loadConfiguration()
    {
        $config = $this->validateConfig($this->defaults);
        $container = $this->getContainerBuilder();

        $container->addDefinition($this->prefix('latteFactory'))
            ->setClass(Engine::class)
            ->addSetup('setTempDirectory', [$config['tempDir']])
            ->addSetup('setAutoRefresh', [$config['debugMode']])
            ->addSetup('setContentType', [Compiler::CONTENT_HTML])
            ->addSetup('Nette\Utils\Html::$xhtml = ?', [FALSE]);
    }


}