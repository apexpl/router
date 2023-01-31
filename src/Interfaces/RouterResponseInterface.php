<?php

namespace Apex\Router\Interfaces;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Router response interface
 */
interface RouterResponseInterface
{

    /**
     * Get middleware
     */
    public function getMiddleware():string;

    /**
     * With Middleware
     */
    public function withMiddleware(string $middleware):static;

    /**
     * Get path params
     */
    public function getPathParams():array;

    /**
     * With path params
     */
    public function withPathParams(array $params):static;

    /**
     * Get translated path
     */
    public function getPathTranslated():string;

    /**
     * With path translated
     */
    public function withPathTranslated(string $path):static;

    /**
     * Get server request
     */
    public function getRequest():ServerRequestInterface;

    /**
     * With server request
     */
    public function withRequest(ServerRequestInterface $request):static;

}


