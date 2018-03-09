<?php

namespace Note\Router;

use Nette\Http\Request;
use Note\Handlers\HandlerRequest;

interface IRouterProvider
{

    /**
     * @param string $method
     * @param string $mask
     * @param callable $callback
     */
    function map($method, $mask, $callback);

    /**
     * @param Request $request
     * @return HandlerRequest|NULL
     */
    function match(Request $request);

}
