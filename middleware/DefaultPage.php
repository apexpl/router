<?php
declare(strict_types = 1);

namespace Middleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

/**
 * Default Middleware
 */
class DefaultPage implements MiddlewareInterface
{

    /**
     * Process request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        // Return default response
        $response = new Response(200, ['Content-type' => 'text/html'], 'This is the default router');
        return $response;

    }

}



