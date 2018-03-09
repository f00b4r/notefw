<?php

namespace Note\Handlers;

use Nette\Http\Request;
use Nette\Http\Response;

final class HandlerRequest
{

    /** @var callable */
    private $handler;

    /** @var array */
    private $parameters = [];

    /**
     * @param callable $handler
     */
    public function __construct(callable $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return callable
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return isset($this->parameters[$key]) ? $this->parameters[$key] : NULL;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function invoke(Request $request, Response $response)
    {
        call_user_func($this->handler, $request, $response, $this);
    }

}
