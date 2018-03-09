<?php

namespace Note\Handlers;

use Nette\Http\Request;
use Nette\Http\Response;

class FoundHandler
{

    /** @var HandlerRequest */
    private $handler;

    /**
     * @param HandlerRequest $handler
     */
    public function __construct(HandlerRequest $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function __invoke(Request $request, Response $response)
    {
        $this->handler->invoke($request, $response);
    }

}
