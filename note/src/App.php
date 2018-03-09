<?php

namespace Note;

use Closure;
use InvalidArgumentException;
use Nette\DI\Container;
use Nette\Http\Response;
use Note\Events\EventsEmitter;
use Note\Router\Dispatcher;

/**
 * @property-read Container $container
 */
class App
{
    /** Modes */
    const DEVELOPMENT = 'development';
    const PRODUCTION = 'production';

    /** @var Container */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @return object
     * @throws InvalidArgumentException
     */
    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        } else if ($this->container->hasService($name)) {
            return $this->container->getService($name);
        }

        throw new InvalidArgumentException();
    }

    /**
     * @param string $service
     * @return object
     */
    protected function get($service)
    {
        return $this->container->getService($service);
    }

    /**
     * @param string $mask
     * @param callable $handler
     */
    protected function map($method, $mask, callable $handler)
    {
        if ($handler instanceof Closure) {
            $handler = $handler->bindTo($this);
        }

        $router = $this->get('note.router');
        $router->map($method, $mask, $handler);
    }

    /**
     * PUBLIC API **************************************************************
     */

    /**
     * @param string $mask
     * @param callable $handler
     */
    public function route($mask, callable $handler)
    {
        $this->map('GET', $mask, $handler);
    }

    /**
     * @return Response
     *
     * @return void
     */
    public function run()
    {
        /** @var EventsEmitter $emitter */
        $emitter = $this->get('note.emitter');
        $emitter->emit('app:run', $this->container);

        /** @var Dispatcher $dispatcher */
        $dispatcher = $this->get('note.dispatcher');
        $emitter->on('app:finalize', function ($handler) {
            $handler($this->httpRequest, $this->httpResponse);
        });

        $dispatcher->dispatch();
    }

}
