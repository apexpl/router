<?php
declare(strict_types = 1);

namespace Apex\Router;

use Apex\Router\Interfaces\RouterResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Router response
 */
class RouterResponse implements RouterResponseInterface
{

    /**
     * Constructor
     */
    public function __construct(
        private string $middleware, 
        private string $path_translated, 
        private array $params,
        private ServerRequestInterface $request
    ) { 

    }

    /**
     * Get http controller
     */
    public function getMiddleware():string
    {
        return $this->middleware;
    }

    /**
     * Get params
     */
    public function getPathParams():array
    {
        return $this->params;
    }

    /**
     * Get path translated
     */
    public function getPathTranslated():string
    {
        return $this->path_translated;
    }

    /**
     * Get server request
     */
    public function getRequest():ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * With middleware
     */
    public function withMiddleware(string $middleware):static
    {

        return new RouterResponse(
            middleware: $middleware,
            path_translated: $this->path_translated, 
            params: $this->params,
            request: $this->request,
        );

    }

    /**
     * With path params
     */
    public function withPathParams(array $params):static
    {

        return new RouterResponse(
            middleware: $this->middleware, 
            path_translated: $this->path_translated, 
            params: $params,
            request: $this->request
        );

    }

    /**
     * With pth translated
     */
    public function withPathTranslated(string $path):static
    {

        return new RouterResponse(
            middleware: $this->middleware, 
            path_translated: $path, 
            params: $this->params,
            request: $this->request,
        );

    }

    /**
     * With server request
     */
    public function withRequest(ServerRequestInterface $request):static
    {

        return new RouterResponse(
            middleware: $this->middleware, 
            path_translated: $this->path_translated, 
            params: $this->params,
            request: $request
        );

    }

}

