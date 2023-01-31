<?php
declare(strict_types = 1);

namespace Middleware;

use Apex\Container\Container;
use Apex\Syrus\Syrus as SyrusEngine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

/**
 * Default http controller, generally intended to serve public web site.
 */
class Syrus implements MiddlewareInterface
{

    #[Inject(Container::class)]
    private Container $cntr;

    /**
     * Process request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        // Init Syrus
        $syrus = new SyrusEngine(
            container_file: $this->cntr->get('syrus_container_file'),
            require_http_method: true
        );

        // Render template via auto-routing based on URI being viewed
        $file = $syrus->doAutoRouting($request->getUri()->getPath());
        $html = $syrus->render($file);

        // Create response
        $code = str_ends_with($file, '404.html') ? 404 : 200;
        return new Response($code, [], $html);
    }

}



