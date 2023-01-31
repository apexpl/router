<?php
declare(strict_types = 1);

namespace Middleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

/**
 * Default http controller, generally intended to serve public web site.
 */
class ContactPage implements MiddlewareInterface
{

    /**
     * Process request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        // Generate response in whatever format (Twig, json, et al)
        $html = "Contents of the contact page";

        // Return PSR7 response
        $response = new Response(200, [], $html);
        return $response;
    }

}



