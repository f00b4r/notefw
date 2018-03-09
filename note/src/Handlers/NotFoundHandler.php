<?php

namespace Note\Handlers;

use Nette\Http\Request;
use Nette\Http\Response;

class NotFoundHandler
{

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response)
    {
        die('NO');
    }

}
