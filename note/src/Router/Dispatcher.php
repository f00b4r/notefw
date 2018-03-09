<?php

namespace Note\Router;

use Nette\Http\Request;
use Note\Events\EventsEmitter;
use Note\Handlers\FoundHandler;
use Note\Handlers\HandlerRequest;
use Note\Handlers\NotFoundHandler;

class Dispatcher
{

    /** @var Router */
    private $router;

    /** @var Request */
    private $request;

    /** @var EventsEmitter */
    private $emitter;

    /**
     * @param Router $router
     * @param Request $request
     * @param EventsEmitter $emitter
     */
    public function __construct(Router $router, Request $request, EventsEmitter $emitter)
    {
        $this->router = $router;
        $this->request = $request;
        $this->emitter = $emitter;

        $this->emitter->on('dispatcher:found', function (HandlerRequest $handler) {
            $this->emitter->emit('app:finalize', new FoundHandler($handler));
        });

        $this->emitter->on('dispatcher:notFound', function () {
            $this->emitter->emit('app:finalize', new NotFoundHandler());
        });
    }

    /**
     * Dispatch the request
     *
     * @return mixed
     */
    public function dispatch()
    {
        $this->emitter->emit('dispatcher:before', $this->request);

        // Try match the route
        $handler = $this->router->match($this->request);

        if ($handler) {
            $this->emitter->emit('dispatcher:found', $handler);
        } else {
            $this->emitter->emit('dispatcher:notFound');
        }
    }

}
