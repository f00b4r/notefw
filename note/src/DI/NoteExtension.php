<?php

namespace Note\DI;

use Nette\DI\CompilerExtension;
use Note\Events\EventsEmitter;
use Note\Router\Dispatcher;
use Note\Router\Router;

class NoteExtension extends CompilerExtension
{

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('router'))
            ->setClass(Router::class);

        $builder->addDefinition($this->prefix('dispatcher'))
            ->setClass(Dispatcher::class);

        $builder->addDefinition($this->prefix('emitter'))
            ->setClass(EventsEmitter::class);
    }

}
