<?php

namespace Note\Extra\Router\Nette\DI;

use Nette\DI\CompilerExtension;
use Note\Extra\Router\Nette\NetteRouterProvider;

class NetteRouterExtension extends CompilerExtension
{
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('provider'))
            ->setClass(NetteRouterProvider::class);
    }


}