<?php

namespace Note\Router;

use Nette\Http\Request;
use Note\Handlers\HandlerRequest;

class Router
{

    /** @var IRouterProvider */
    private $provider;

    /**
     * @param IRouterProvider $provider
     */
    public function __construct(IRouterProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param string $method
     * @param string $mask
     * @param callable $callback
     */
    public function map($method, $mask, $callback)
    {
        $this->provider->map($method, $mask, $callback);
    }

    /**
     * @param Request $request
     * @return HandlerRequest
     */
    public function match(Request $request)
    {
        return $this->provider->match($request);
    }

}
