<?php

namespace Note\Extra\Router\Nette;

use InvalidArgumentException;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Http\Request;
use Note\Handlers\HandlerRequest;
use Note\Router\IRouterProvider;

class NetteRouterProvider implements IRouterProvider
{

    /** @var RouteList */
    private $routes;

    public function __construct()
    {
        $this->routes = new RouteList();
    }

    /**
     * @param string $method
     * @param string $mask
     * @param $callback
     */
    public function map($method, $mask, $callback)
    {
        if ($method !== 'GET') {
            throw new InvalidArgumentException('Only GET methods are supported at this time');
        }

        $this->routes[] = new Route($mask, [
            'callback' => $callback,
            'presenter' => 'Note:Fake'
        ]);
    }

    /**
     * @param Request $request
     * @return HandlerRequest|NULL
     */
    public function match(Request $request)
    {
        $request = $this->routes->match($request);

        if ($request) {
            $handler = new HandlerRequest($request->parameters['callback']);
            $handler->setParameters($request->getParameters());
            return $handler;
        };

        return NULL;
    }

}
