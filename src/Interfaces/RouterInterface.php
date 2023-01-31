<?php

namespace Apex\Router\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Router interface
 */
interface RouterInterface extends RequestHandlerInterface
{

    /**
     * Lookup a route
     */
    public function lookup(ServerRequestInterface $request):RouterResponseInterface;

}


